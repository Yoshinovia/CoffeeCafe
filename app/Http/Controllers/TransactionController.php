<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->get();
        return view('kasir.transaction.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $menuItems = [];

            // Fetch all menus at once to reduce database queries
            $menuIds = collect($request->input('items'))->pluck('menu_id')->unique()->toArray();
            $menus = Menu::with('recipes.rawMaterial')->whereIn('id', $menuIds)->get()->keyBy('id');

            foreach ($request->input('items') as $item) {
                $menu = $menus->get($item['menu_id']);

                if (!$menu || !$menu->is_available) {
                    throw new \Exception('Menu item not found or not available: ' . $item['menu_id']);
                }

                $itemSubtotal = $menu->price * $item['quantity'];
                $subtotal += $itemSubtotal;
                $menuItems[] = [
                    'menu' => $menu,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'subtotal' => $itemSubtotal,
                ];

                // Check and decrement raw material stock
                foreach ($menu->recipes as $recipe) {
                    $rawMaterial = $recipe->rawMaterial;
                    $requiredQuantity = $recipe->quantity_used * $item['quantity'];

                    if ($rawMaterial->stock < $requiredQuantity) {
                        throw new \Exception('Insufficient stock for ' . $rawMaterial->name . '. Required: ' . $requiredQuantity . $rawMaterial->unit . ', Available: ' . $rawMaterial->stock . $rawMaterial->unit);
                    }
                    $rawMaterial->stock -= $requiredQuantity;
                    $rawMaterial->save();
                }
            }

            $tax = 0; // Assuming no tax for now, or implement tax calculation if needed
            $total = $subtotal + $tax;
            $paidAmount = $request->input('paid_amount');
            $change = $paidAmount - $total;

            if ($change < 0) {
                throw new \Exception('Paid amount is less than the total. Missing: ' . abs($change));
            }

            // Create Sale record
            $sale = Sale::create([
                'user_id' => Auth::id(), // Assuming a logged-in user (kasir)
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'paid' => $paidAmount,
                'change' => $change,
            ]);

            // Create SaleItem records
            foreach ($menuItems as $menuItem) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'menu_id' => $menuItem['menu']->id,
                    'qty' => $menuItem['quantity'],
                    'price' => $menuItem['price'],
                    'subtotal' => $menuItem['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaction successful',
                'sale' => $sale->load('items.menu'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function adminIndex()
    {
        $sales = Sale::with('items.menu', 'kasir')->latest()->get();
        return view('admin.transaction.index', compact('sales'));
    }
}

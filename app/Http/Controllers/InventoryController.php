<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{

    public function index()
    {
        $rawMaterials = RawMaterial::orderBy('name')->get();
        return view('admin.inventory.index', compact('rawMaterials'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('raw_materials')],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            RawMaterial::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'stock' => (float) $request->stock,
                'min_stock_alert' => (float) $request->min_stock_alert,
            ]);


            return redirect()->route('admin.inventory.index')->with('success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error');
        }
    }

    /**
     * Menampilkan form edit dan memproses update bahan baku.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        return view('admin.inventory.edit', compact('rawMaterial'));
    }

    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('raw_materials')->ignore($rawMaterial->id)],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $rawMaterial->update([
                'name' => $request->name,
                'unit' => $request->unit,
                'stock' => (float) $request->stock,
                'min_stock_alert' => (float) $request->min_stock_alert,
            ]);

            return redirect()->route('admin.inventory.index')->with('success', 'Bahan baku berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui bahan baku.');
        }
    }


    /**
     * Menghapus bahan baku.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        try {
            $rawMaterial->delete();
            return redirect()->route('admin.inventory.index')->with('success', 'Bahan baku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus bahan baku.');
        }
    }
}

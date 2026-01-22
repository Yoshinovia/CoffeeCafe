<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        // Daily stats
        $dailySales = Sale::whereDate('created_at', $today)->sum('total');
        $dailyTransactions = Sale::whereDate('created_at', $today)->count();

        // Monthly stats
        $monthlySales = Sale::whereMonth('created_at', $today->month)
                              ->whereYear('created_at', $today->year)
                              ->sum('total');

        // Best-selling items today
        $bestSellingItemsToday = SaleItem::with('menu')
            ->whereHas('sale', function ($query) use ($today) {
                $query->whereDate('created_at', $today);
            })
            ->selectRaw('menu_id, SUM(qty) as total_quantity')
            ->groupBy('menu_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('admin.home', compact(
            'dailySales',
            'dailyTransactions',
            'monthlySales',
            'bestSellingItemsToday'
        ));
    }
}

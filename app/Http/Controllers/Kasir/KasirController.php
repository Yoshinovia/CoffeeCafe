<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Sale;
use App\Models\RawMaterial;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $kasirId = Auth::id();

        // Stats for the logged-in kasir for today
        $dailySales = Sale::where('user_id', $kasirId)
                          ->whereDate('created_at', $today)
                          ->sum('total');

        $dailyTransactions = Sale::where('user_id', $kasirId)
                                 ->whereDate('created_at', $today)
                                 ->count();

        // Recent transactions by the logged-in kasir
        $recentTransactions = Sale::where('user_id', $kasirId)
                                  ->latest()
                                  ->limit(5)
                                  ->get();

        // Low stock raw materials
        $lowStockRawMaterials = RawMaterial::whereColumn('stock', '<=', 'min_stock_alert')
                                            ->where('stock', '>', 0)
                                            ->get();

        return view('kasir.dashboard', compact(
            'dailySales',
            'dailyTransactions',
            'recentTransactions',
            'lowStockRawMaterials'
        ));
    }
}

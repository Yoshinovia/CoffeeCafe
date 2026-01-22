@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Omzet Hari Ini</h2>
            <p class="text-3xl font-bold text-gray-800">@rp($dailySales)</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Transaksi Hari Ini</h2>
            <p class="text-3xl font-bold text-gray-800">{{ $dailyTransactions }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Omzet Bulan Ini</h2>
            <p class="text-3xl font-bold text-gray-800">@rp($monthlySales)</p>
        </div>
    </div>

    {{-- Best Selling Items --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Menu Terlaris Hari Ini</h2>
        @if($bestSellingItemsToday->isNotEmpty())
            <ul class="divide-y divide-gray-200">
                @foreach($bestSellingItemsToday as $item)
                    <li class="py-3 flex justify-between items-center">
                        <span class="text-gray-800">{{ $item->menu->name ?? 'Menu tidak ditemukan' }}</span>
                        <span class="font-bold text-gray-600 bg-gray-200 px-3 py-1 rounded-full">{{ $item->total_quantity }} terjual</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada penjualan hari ini.</p>
        @endif
    </div>
</div>
@endsection
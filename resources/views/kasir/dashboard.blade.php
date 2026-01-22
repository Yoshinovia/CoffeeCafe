@extends('layouts.kasir')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard Kasir</h1>
        <a href="{{ route('kasir.transaction.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Transaksi Baru
        </a>
    </div>
    
    <p class="mb-6">Selamat datang, {{ auth()->user()->name }}!</p>

    {{-- Low Stock Alert --}}
    @if ($lowStockRawMaterials->isNotEmpty())
        <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <h3 class="font-bold">Peringatan Stok Menipis!</h3>
            <ul>
                @foreach ($lowStockRawMaterials as $rawMaterial)
                    <li>Stok {{ $rawMaterial->name }} tinggal {{ $rawMaterial->stock }} {{ $rawMaterial->unit }}. Mohon beritahu admin untuk restock.</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Total Penjualan Anda Hari Ini</h2>
            <p class="text-3xl font-bold text-gray-800">@rp($dailySales)</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-600 mb-2">Jumlah Transaksi Anda Hari Ini</h2>
            <p class="text-3xl font-bold text-gray-800">{{ $dailyTransactions }}</p>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Transaksi Terakhir Anda</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bayar</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTransactions as $sale)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">#{{ $sale->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $sale->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">@rp($sale->total)</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">@rp($sale->paid)</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">@rp($sale->change)</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">Anda belum memiliki transaksi hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
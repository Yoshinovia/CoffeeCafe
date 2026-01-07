@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Edit Bahan Baku</h2>

    {{-- Error Alert --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-4 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Stok
            </a>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.inventory.update', $rawMaterial) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Bahan Baku --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Bahan Baku</label>
                    <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                        @error('name') border-red-500 @enderror" 
                        id="name" name="name" value="{{ old('name', $rawMaterial->name) }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Satuan --}}
                <div class="mb-4">
                    <label for="unit" class="block text-sm font-medium text-gray-700">Satuan (Contoh: ml, gram, liter, kg)</label>
                    <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                        @error('unit') border-red-500 @enderror" 
                        id="unit" name="unit" value="{{ old('unit', $rawMaterial->unit) }}" required>
                    @error('unit')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Stok --}}
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('stock') border-red-500 @enderror" 
                            id="stock" name="stock" value="{{ old('stock', $rawMaterial->stock) }}" required min="0">
                        @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Batas Minimum Notifikasi Stok --}}
                    <div class="mb-4">
                        <label for="min_stock_alert" class="block text-sm font-medium text-gray-700">Batas Minimum Notifikasi Stok</label>
                        <input type="number" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('min_stock_alert') border-red-500 @enderror" 
                            id="min_stock_alert" name="min_stock_alert" value="{{ old('min_stock_alert', $rawMaterial->min_stock_alert) }}" required min="0">
                        @error('min_stock_alert')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Sistem akan memberi notifikasi jika stok mencapai batas ini.</p>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="pt-4 border-t border-gray-200 mt-4">
                    <button type="submit" class="w-full md:w-auto cursor-pointer inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
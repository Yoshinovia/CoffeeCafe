@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
        <i class="fas fa-plus mr-3"></i> Tambah Menu Baru
    </h2>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf

                {{-- Nama Menu --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Menu (Contoh: Caramel Latte)</label>
                    <input type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                        @error('name') border-red-500 @enderror" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required>
                    @error('name') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>
                
                {{-- Harga Jual --}}
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                    <input type="number" 
                        step="1000" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                        @error('price') border-red-500 @enderror" 
                        name="price" 
                        value="{{ old('price') }}" 
                        required 
                        min="0">
                    @error('price') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                        @error('category') border-red-500 @enderror" 
                        name="category" 
                        required>
                        <option value="Minuman" {{ old('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Simpan Menu
                    </button>
                    <a href="{{ route('admin.menu.index') }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
        <i class="fas fa-plus mr-3"></i> Tambah Bahan Baku untuk Resep: {{ $menu->name }}
    </h2>
    <p class="text-gray-600 mb-6">Pilih bahan baku dan tentukan jumlah yang digunakan untuk satu porsi menu ini.</p>

    {{-- Error Alert --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.menu.recipe.store', $menu) }}" method="POST">
                @csrf

                {{-- Pilih Bahan Baku (Select) --}}
                <div class="mb-4">
                    <label for="raw_material_id" class="block text-sm font-medium text-gray-700">Pilih Bahan Baku</label>
                    <select 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                        @error('raw_material_id') border-red-500 @enderror" 
                        id="raw_material_id" name="raw_material_id" required>
                        <option value="">-- Pilih Bahan Baku --</option>
                        @foreach ($rawMaterials as $material)
                            @if (!in_array($material->id, $existingRawMaterialIds))
                                <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" {{ old('raw_material_id') == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }} (Stok: {{ $material->unit }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('raw_material_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Jumlah Digunakan (Input Group) --}}
                <div class="mb-6">
                    <label for="quantity_used" class="block text-sm font-medium text-gray-700">Jumlah Digunakan (per Porsi)</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="number" step="0.01" 
                            class="flex-1 min-w-0 block w-full px-3 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('quantity_used') border-red-500 ring-red-500 @enderror" 
                            id="quantity_used" name="quantity_used" value="{{ old('quantity_used') }}" required min="0.01">
                        
                        {{-- Input Group Append (Satuan) --}}
                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm" id="unit_display">
                            ...
                        </span>
                    </div>
                    
                    @error('quantity_used')
                        {{-- Menggunakan d-block pada Bootstrap, di Tailwind cukup p --}}
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Masukkan jumlah yang akan dikurangi dari stok saat menu ini terjual 1 porsi.</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out cursor-pointer">
                        Simpan Resep
                    </button>
                    <a href="{{ route('admin.menu.edit', $menu) }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk menampilkan unit yang benar saat memilih bahan baku
    document.addEventListener('DOMContentLoaded', function() {
        const rawMaterialSelect = document.getElementById('raw_material_id');
        const unitDisplay = document.getElementById('unit_display');

        function updateUnitDisplay() {
            var selectedOption = rawMaterialSelect.options[rawMaterialSelect.selectedIndex];
            var unit = selectedOption ? selectedOption.getAttribute('data-unit') : null;
            unitDisplay.textContent = unit || '...';
        }

        rawMaterialSelect.addEventListener('change', updateUnitDisplay);
        
        // Panggil sekali saat load untuk nilai awal (jika old('raw_material_id') ada)
        updateUnitDisplay();
    });
</script>
@endsection
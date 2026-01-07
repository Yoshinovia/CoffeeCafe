@extends('layouts.admin')

@section('content')
<br class="my-4">

<h3 class="text-2xl font-semibold text-gray-800 mb-3 flex items-center">
     Resep Menu (Bahan Baku)
</h3>
<p class="text-gray-600 mb-4">Tetapkan bahan baku dan jumlah yang dikonsumsi untuk satu porsi {{ $menu->name }}.</p>

<div class="bg-white shadow-md rounded-lg p-5 mb-6">
    {{-- Tombol Tambah --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.menu.recipe.create', $menu) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#73AF6F] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i> Tambah Bahan Baku ke Resep
        </a>
    </div>

    @if ($menu->recipes->isEmpty())
        {{-- Alert Kosong --}}
        <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative text-sm" role="alert">
            Menu ini belum memiliki resep. Silakan tambahkan bahan baku.
        </div>
    @else
        {{-- Tabel Resep --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bahan Baku
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Digunakan (per Porsi)
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($menu->recipes as $recipe)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $recipe->rawMaterial->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ number_format($recipe->quantity_used, 2) }} {{ $recipe->unit_used }}
                                <p class="text-xs text-gray-500 mt-0.5">
                                    (Stok tersedia: {{ number_format($recipe->rawMaterial->stock, 2) }} {{ $recipe->rawMaterial->unit }})
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <form action="{{ route('admin.menu.recipe.destroy', [$menu, $recipe]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus bahan ini dari resep?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out p-1"
                                        title="Hapus Resep">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
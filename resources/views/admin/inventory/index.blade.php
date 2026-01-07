@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                Daftar Stok Bahan Baku
            </h2>
            
        </div>

        {{-- Tabel Data Bahan Baku --}}
        <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
            <div class="px-4 py-4 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-semibold text-gray-900">
                    Data Bahan Baku
                </h3>
                <a href="{{ route('admin.inventory.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#73AF6F] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i> Tambah Bahan Baku Baru
            </a>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    {{-- Menggunakan class untuk styling tabel yang lebih baik --}}
                    <table class="min-w-full divide-y divide-gray-200" id="dataTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Bahan Baku
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok Saat Ini
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Satuan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Batas Min. Notifikasi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
    @foreach ($inventory as $inventoryItem)
        <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
            <td class="px-6 py-4 text-sm">
                {{ $loop->iteration }}
            </td>

            <td class="px-6 py-4 text-sm">
                {{ $inventoryItem->name }}
            </td>

            <td class="px-6 py-4 text-sm">
                {{ number_format($inventoryItem->stock, 2) }}
            </td>

            <td class="px-6 py-4 text-sm">
                {{ $inventoryItem->unit }}
            </td>

            <td class="px-6 py-4 text-sm">
                {{ number_format($inventoryItem->min_stock_alert, 2) }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                @php
                    $badgeClass = 'bg-green-100 text-green-800';

                    if ($inventoryItem->stock < $inventoryItem->min_stock_alert) {
                        $badgeClass = 'bg-red-100 text-red-800';
                    } elseif ($inventoryItem->stock <= $inventoryItem->min_stock_alert * 1.5) {
                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                    }
                @endphp

                <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $badgeClass }}">
                    {{ $inventoryItem->stock < $inventoryItem->min_stock_alert ? 'Rendah' : 'Aman' }}
                </span>
            </td>

            <td class="px-6 py-4 text-center text-sm font-medium flex items-center">
                <a href="{{ route('admin.inventory.edit', $inventoryItem) }}"
                   class="text-indigo-600 hover:text-indigo-900 mr-4">
                    Edit
                </a>

                <form action="{{ route('admin.inventory.destroy', $inventoryItem) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus {{ $inventoryItem->name }}?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-red-600 hover:text-red-900">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
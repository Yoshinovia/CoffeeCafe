@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center">
        Daftar Menu Produk
    </h2>
    
    {{-- Success Alert --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card (Container Data Menu) --}}
    <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
        <div class="px-4 py-4 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <h6 class="text-lg font-semibold text-black">Data Menu</h6>
            <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#73AF6F] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i> Tambah Menu Baru
            </a>
        </div>
        
        {{-- Card Body and Table --}}
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="dataTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Menu
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ketersediaan
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($menus as $menu)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $menu->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $menu->category }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Mengubah badge Bootstrap ke Tailwind --}}
                                    @php
                                        $statusClass = $menu->is_available 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-red-100 text-red-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $menu->is_available ? 'Tersedia' : 'Habis/Non-aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.menu.edit', $menu) }}" 
                                            class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out mr-4"
                                            title="Edit">
                                            Edit
                                        </a>
                                        
                                        {{-- Tombol Hapus (Form DELETE) --}}
                                        <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out cursor-pointer"
                                                title="Hapus">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
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
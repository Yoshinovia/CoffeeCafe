<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua Menu.
     */
    public function index()
    {
        $menus = Menu::orderBy('category')->orderBy('name')->get();
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk membuat menu baru.
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Menyimpan menu baru ke database (Skenario: Tambah 'Caramel Latte').
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('menus')],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'is_available' => ['boolean'],
        ]);

        Menu::create([
            'name' => $request->name,
            'price' => (float)$request->price,
            'category' => $request->category,
            'is_available' => $request->is_available ?? true,
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu baru "' . $request->name . '" berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit menu (Skenario: Mengubah harga 'Cappuccino').
     */
    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    /**
     * Memperbarui detail menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('menus')->ignore($menu->id)],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'is_available' => ['boolean'],
        ]);

        $menu->update([
            'name' => $request->name,
            'price' => (float)$request->price,
            'category' => $request->category,
            'is_available' => $request->is_available ?? true,
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu "' . $menu->name . '" berhasil diperbarui!');
    }

    /**
     * Menghapus menu (Skenario: Menghapus menu lama).
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu "' . $menu->name . '" berhasil dihapus!');
    }
}

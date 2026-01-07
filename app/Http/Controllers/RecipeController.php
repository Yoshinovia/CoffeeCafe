<?php

// app/Http/Controllers/RecipeController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    /**
     * Menampilkan form untuk menambah bahan baku ke menu.
     */
    public function create(Menu $menu)
    {
        // Ambil semua bahan baku yang tersedia
        $rawMaterials = RawMaterial::orderBy('name')->get();

        // Ambil ID bahan baku yang sudah ada di resep menu ini
        $existingRawMaterialIds = $menu->recipes->pluck('raw_material_id')->toArray();

        return view('admin.recipe.create', compact('menu', 'rawMaterials', 'existingRawMaterialIds'));
    }

    /**
     * Menyimpan bahan baku baru ke resep menu.
     */
    public function store(Request $request, Menu $menu)
    {
        // 1. Validasi Data
        $request->validate([
            'raw_material_id' => [
                'required',
                'exists:raw_materials,id',
                // Pastikan bahan baku belum ada di resep menu ini
                \Illuminate\Validation\Rule::unique('recipes')->where(function ($query) use ($menu) {
                    return $query->where('menu_id', $menu->id);
                })
            ],
            'quantity_used' => ['required', 'numeric', 'min:0.01'],
        ], [
            'raw_material_id.unique' => 'Bahan baku ini sudah terdaftar dalam resep.'
        ]);

        // Ambil detail bahan baku untuk mendapatkan unit
        $rawMaterial = RawMaterial::find($request->raw_material_id);

        // 2. Simpan Resep
        Recipe::create([
            'menu_id' => $menu->id,
            'raw_material_id' => $rawMaterial->id,
            'quantity_used' => (float)$request->quantity_used,
            'unit_used' => $rawMaterial->unit, // Menggunakan unit dari RawMaterial
        ]);

        // 3. Redirect
        return redirect()->route('admin.menu.edit', $menu)
            ->with('success', 'Bahan baku berhasil ditambahkan ke resep "' . $menu->name . '"!');
    }

    /**
     * Menghapus bahan baku dari resep menu.
     */
    public function destroy(Menu $menu, Recipe $recipe)
    {
        // Pastikan resep yang dihapus memang milik menu ini
        if ($recipe->menu_id !== $menu->id) {
            return redirect()->back()->with('error', 'Akses tidak valid.');
        }

        $materialName = $recipe->rawMaterial->name;
        $recipe->delete();

        return redirect()->route('admin.menu.edit', $menu)
            ->with('success', 'Bahan baku "' . $materialName . '" berhasil dihapus dari resep.');
    }
}

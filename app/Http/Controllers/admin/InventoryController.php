<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class InventoryController extends Controller
{

    public function index()
    {
        $inventory = RawMaterial::orderBy('name')->get();
        return view('admin.inventory.index', compact('inventory'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('raw_materials')],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
        ]);

        RawMaterial::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'stock' => (float) $request->stock,
            'min_stock_alert' => (float) $request->min_stock_alert,
        ]);

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit(RawMaterial $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, RawMaterial $inventory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('raw_materials')->ignore($inventory->id)],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
        ]);

        $inventory->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'stock' => (float) $request->stock,
            'min_stock_alert' => (float) $request->min_stock_alert,
        ]);

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function destroy(RawMaterial $inventory)
    {
        $inventory->delete();

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', 'Bahan baku berhasil dihapus.');
    }
}

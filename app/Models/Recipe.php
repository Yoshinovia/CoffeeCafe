<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'raw_material_id',
        'quantity_used',
        'unit_used',
    ];

    protected $casts = [
        'quantity_used' => 'float',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
}

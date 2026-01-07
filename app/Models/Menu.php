<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category',
        'is_available'
    ];

    protected $casts = [
        'price' => 'float',
        'is_available' => 'boolean',
    ];

    public function recipes(){
        return $this->hasMany(Recipe::class);
    }

    public function rawMaterials(){
        return $this->belongsToMany(RawMaterial::class, 'recipes')->using(Recipe::class)->withPivot('quantity_used', 'unit_used');
    }
}

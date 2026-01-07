<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterial extends Model
{
    use HasFactory;

    protected $table = 'raw_materials';

    protected $fillable = [
        'name',
        'stock',
        'unit',
        'min_stock_alert',
    ];

    protected $casts = [
        'stock' => 'float',
        'min_stock_alert' => 'float',
    ];

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'Habis';
        } elseif ($this->stock <= $this->min_stock_alert) {
            return 'Menipis';
        } else {
            return 'Aman';
        }
    }

    public function getStockStatusBadgeClassAttribute()
    {
        switch ($this->stock_status) {
            case 'Habis':
                return 'bg-red-500 text-white';
            case 'Menipis':
                return 'bg-yellow-500 text-black';
            default:
                return 'bg-green-500 text-white';
        }
    }

    public function recipes(){
        return $this->hasMany(Recipe::class);
    }
}

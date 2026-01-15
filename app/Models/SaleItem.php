<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sale_id',
        'menu_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function manu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}

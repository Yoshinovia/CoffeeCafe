<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'tax',
        'total',
        'paid',
        'change',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'sub_total',
        'total',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

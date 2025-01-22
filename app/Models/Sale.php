<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{

    protected $fillable = [
        'user_id',
        'customer_id',
        'discount',
        'sub_total',
        'total',
        'paid',
        'due',
        'note',
        'is_returned',
        'status',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function products(){
        return $this->hasMany(SaleProduct::class);
    }

}

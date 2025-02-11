<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'user_id',
        'sub_total',
        'tax',
        'discount_value',
        'discount_type',
        'shipping',
        'grand_total',
        'status',
        'date'
    ];
    public function items()
    {
        return $this->hasMany(PurchaseProduct::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}

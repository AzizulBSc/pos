<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payable_type', 'payable_id', 'payment_type', 'amount', 'transaction_id', 'transaction_type', 'note', 'user_id'];

    public function payable()
    {
        return $this->morphTo();
    }
}

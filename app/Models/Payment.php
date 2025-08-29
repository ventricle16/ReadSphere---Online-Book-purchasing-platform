<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','provider','status','amount','currency',
        'stripe_payment_intent','stripe_payment_method','raw_response'
    ];

    protected $casts = ['raw_response' => 'array'];

    public function order(){ return $this->belongsTo(Order::class); }
}
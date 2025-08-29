<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'amount',        // DB column
        'status',
        'payment_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accessor so you can use $order->total_amount safely
     */
    public function getTotalAmountAttribute()
    {
        // Prefer stored amount (set at order creation)
        return $this->amount ?? 0;
    }

    /**
     * Helper to recalc from order items if needed
     */
    public function calculateTotalAmount()
    {
        // Use the stored amount which already includes tax and any discounts
        return $this->amount ?? $this->items->sum(fn($item) => $item->price * $item->quantity);
    }
}

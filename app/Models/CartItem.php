<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'book_id',
        'quantity',
        'price',
        'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the book that owns the item.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Update quantity and recalculate subtotal.
     */
    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->subtotal = $this->price * $quantity;
        $this->save();
        
        $this->cart->refreshTotals();
    }
}

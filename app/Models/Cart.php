<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'item_count',
        'discount_code',
        'discount_percent',
        'discount_amount'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function addItem(Book $book, $quantity = 1)
    {
        $existingItem = $this->items()->where('book_id', $book->id)->first();
        if ($book->price === null) {
            throw new \Exception('Cannot add book to cart: Price is not set');
        }

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->subtotal = $existingItem->quantity * $book->price;
            $existingItem->save();
        } else {
            $this->items()->create([
                'book_id'  => $book->id,
                'quantity' => $quantity,
                'price'    => $book->price,
                'subtotal' => $book->price * $quantity
            ]);
        }

        $this->refreshTotals();
    }
    
    public function calculateTotalAmount()
    {
        return $this->items->sum(fn($item) => $item->book->price * $item->quantity);
    }

     public function refreshTotals()
    {
        $this->total_amount = $this->items()->sum('subtotal');
        $this->item_count = $this->items()->sum('quantity');
        $this->save();
    }


    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        $this->items()->delete();
        $this->refreshTotals();
    }


    /**
     * Apply discount coupon to cart.
     */
    public function applyDiscount($couponCode)
    {
        $discounts = [
            'read50' => 50,
            'nuhan20' => 20
        ];


        if (!array_key_exists($couponCode, $discounts)) {
            throw new \Exception('Invalid coupon code');
        }


        $this->discount_code = $couponCode;
        $this->discount_percent = $discounts[$couponCode];
        $this->discount_amount = $this->total_amount * ($discounts[$couponCode] / 100);
        $this->save();


        return $this;
    }


    /**
     * Remove discount from cart.
     */
    public function removeDiscount()
    {
        $this->discount_code = null;
        $this->discount_percent = 0;
        $this->discount_amount = 0;
        $this->save();


        return $this;
    }


    /**
     * Get the final total amount after discount.
     */
    public function getFinalTotalAttribute()
    {
        // Always ensure latest totals
        $this->refreshTotals();

        $subtotal = $this->total_amount - ($this->discount_amount ?? 0);
        $tax = $subtotal * 0.08;

        return max(0, $subtotal + $tax); // never negative
    }




    /**
     * Get the subtotal after discount (before tax).
     */
    public function getSubtotalAfterDiscountAttribute()
    {
        return $this->total_amount - ($this->discount_amount ?? 0);
    }
}





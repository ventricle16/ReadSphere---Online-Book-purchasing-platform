<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ok to extend
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'profile_picture', 'bio'];
    public function wishlist()
    {
        return $this->belongsToMany(Book::class, 'wishlist', 'user_id', 'book_id')
                    ->withTimestamps();
    }


    // cart relationship: one-to-one with cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get or create user's cart
     */
    public function getCart()
    {
        if (!$this->cart) {
            $this->cart()->create([
                'user_id' => $this->id,
                'total_amount' ,
                'item_count' => 0
            ]);
            $this->load('cart');
        }
        return $this->cart;
    }
}

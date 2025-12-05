<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    /**
     * WHY these fields?
     *
     * user_id → Which customer owns this cart (can be NULL for guests)
     * session_id → For guest users (before login)
     */
    protected $fillable = [
        'user_id',
        'session_id',
    ];

    /**
     * RELATIONSHIP: Cart belongs to User (optional - guests don't have user_id)
     *
     * $cart->user → Gets the customer (if logged in)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP: Cart has many CartItems (products in the cart)
     *
     * $cart->items → Gets all products in cart
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * HELPER METHOD: Calculate total items in cart
     *
     * Example: 3 laptops + 2 mice = 5 items
     */
    public function getTotalItems(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * HELPER METHOD: Calculate cart total price
     *
     * Loops through all items and adds up: quantity × price
     */
    public function getTotalPrice(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * HELPER METHOD: Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return $this->items()->count() === 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /**
     * WHY these fields?
     *
     * cart_id    → Which cart this item is in
     * product_id → Which product
     * quantity   → How many units
     * price      → Price at time of adding (in case product price changes later)
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * RELATIONSHIP: CartItem belongs to Cart
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * RELATIONSHIP: CartItem belongs to Product
     *
     * WHY?
     * So you can get product name, image, vendor:
     * $cartItem->product->name
     * $cartItem->product->vendor->business_name
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * HELPER METHOD: Get subtotal for this cart item
     */
    public function getSubtotal(): float
    {
        return $this->quantity * $this->price;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * WHY fillable?
     * - Lists which columns can be mass-assigned (safety feature)
     * - Without this, Order::create(['total' => 100]) would fail
     */
    protected $fillable = [
        'user_id',              // Who placed the order
        'order_number',         // Unique order number (ORD-12345)
        'status',               // pending, processing, completed, cancelled
        'subtotal',             // Price before shipping/tax
        'shipping_cost',        // Delivery fee
        'tax',                  // Tax amount
        'total',                // Final amount paid
        'payment_method',       // stripe, paypal, cod
        'payment_status',       // pending, paid, failed
        'shipping_address',     // Where to deliver
        'notes',                // Customer notes
    ];

    /**
     * WHY casts?
     * - Tells Laravel to automatically convert database values
     * - 'decimal:2' = always show 2 decimal places ($10.00 not $10)
     * - 'array' = converts JSON to PHP array automatically
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'shipping_address' => 'array',  // Stored as JSON in DB
    ];

    /**
     * RELATIONSHIP: Order belongs to User (the customer)
     *
     * HOW IT WORKS:
     * $order->user        → Gets the customer who placed this order
     * User has many Orders → $user->orders
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP: Order has many OrderItems (products in the order)
     *
     * WHY?
     * One order can have multiple products:
     * Order #123 → Laptop, Mouse, Keyboard
     *
     * HOW TO USE:
     * $order->items  → Get all products in this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * HELPER METHOD: Check if order is pending
     *
     * WHY?
     * Instead of: if ($order->status === 'pending')
     * Clean code: if ($order->isPending())
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * HELPER METHOD: Check if order is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * HELPER METHOD: Check if payment is successful
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}

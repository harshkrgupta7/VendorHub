<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * WHY these fields?
     *
     * order_id        → Which order this item belongs to
     * product_id      → Which product was purchased
     * vendor_id       → Which vendor sold it (MULTI-VENDOR KEY!)
     * quantity        → How many units
     * price           → Price per unit at time of purchase
     * vendor_earnings → What vendor gets after commission
     * admin_commission → What platform keeps
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'quantity',
        'price',
        'vendor_earnings',
        'admin_commission',
    ];

    /**
     * WHY casts?
     * Ensures prices are always formatted correctly
     */
    protected $casts = [
        'price' => 'decimal:2',
        'vendor_earnings' => 'decimal:2',
        'admin_commission' => 'decimal:2',
    ];

    /**
     * RELATIONSHIP: OrderItem belongs to Order
     *
     * $orderItem->order → Gets the parent order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * RELATIONSHIP: OrderItem belongs to Product
     *
     * $orderItem->product → Gets product details (name, image, etc.)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * RELATIONSHIP: OrderItem belongs to Vendor
     *
     * WHY IMPORTANT FOR MULTI-VENDOR:
     * This tracks which vendor sold this specific item
     *
     * Example:
     * Order #123 has 3 items:
     * - Item 1: vendor_id = 5 (Vendor A)
     * - Item 2: vendor_id = 5 (Vendor A)
     * - Item 3: vendor_id = 8 (Vendor B)
     *
     * Now you can show:
     * - Vendor A: "You have 2 items in Order #123"
     * - Vendor B: "You have 1 item in Order #123"
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * HELPER METHOD: Calculate subtotal for this item
     *
     * Example: 3 laptops × $500 = $1500
     */
    public function getSubtotal(): float
    {
        return $this->quantity * $this->price;
    }
}

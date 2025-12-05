<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /**
     * WHY these fields?
     *
     * product_id → Which product is being reviewed
     * user_id    → Who wrote the review
     * rating     → Stars (1-5)
     * comment    → Written feedback
     * is_verified → Did customer actually buy this product?
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * RELATIONSHIP: Review belongs to Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * RELATIONSHIP: Review belongs to User (the customer)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * HELPER METHOD: Check if review is positive (4-5 stars)
     */
    public function isPositive(): bool
    {
        return $this->rating >= 4;
    }
}

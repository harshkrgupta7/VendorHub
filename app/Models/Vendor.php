<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    /**
     * The attributes that are mass assignable.
     * These columns can be filled using create() or update()
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'slug',
        'description',
        'business_email',
        'business_phone',
        'business_address',
        'logo',
        'commission_rate',
        'status',
        'total_earnings',
        'available_balance',
        'total_sales',
        'performance_score',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     * Tells Laravel how to treat these columns
     */
    protected $casts = [
        'commission_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'performance_score' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    /**
     * RELATIONSHIP: Vendor belongs to a User
     * Every vendor has a user account to login
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELATIONSHIP: Vendor has many Products
     * One vendor can sell many products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * RELATIONSHIP: Vendor has many Order Items
     * Tracks all items sold by this vendor
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * RELATIONSHIP: Vendor has many Payouts
     * Tracks all payout requests
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(VendorPayout::class);
    }

    /**
     * HELPER: Check if vendor is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * HELPER: Check if vendor is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}

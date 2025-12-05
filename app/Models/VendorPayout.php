<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPayout extends Model
{
    /**
     * WHY these fields?
     *
     * vendor_id      → Which vendor is requesting money
     * amount         → How much they want to withdraw
     * status         → pending, approved, rejected, paid
     * payment_method → bank_transfer, paypal, etc.
     * reference      → Transaction ID (after payment)
     * approved_at    → When admin approved
     * paid_at        → When money was sent
     * notes          → Admin notes (rejection reason, etc.)
     */
    protected $fillable = [
        'vendor_id',
        'amount',
        'status',
        'payment_method',
        'payment_details',
        'reference',
        'approved_at',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * RELATIONSHIP: Payout belongs to Vendor
     *
     * $payout->vendor → Gets vendor details
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * HELPER METHOD: Check if payout is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * HELPER METHOD: Check if payout is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * HELPER METHOD: Check if payout is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}

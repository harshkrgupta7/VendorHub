<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * WHY these fields?
     *
     * name           → User's full name
     * email          → Login email (must be unique)
     * password       → Encrypted password
     * role           → customer, vendor, admin
     * email_verified_at → When user verified their email
     * remember_token → For "Remember Me" feature
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',              // NEW: customer, vendor, admin
        'phone',             // NEW: Phone number
        'avatar',            // NEW: Profile picture
    ];

    /**
     * WHY hidden?
     * These fields should NEVER be sent to frontend/API
     * (Security: don't expose passwords or tokens)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * WHY casts?
     *
     * email_verified_at → Convert to Carbon date object
     * password → Automatically hashed when saving
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIP: User has one Vendor account (if they're a vendor)
     *
     * WHY?
     * Not all users are vendors. Only users with role='vendor' have this.
     *
     * USAGE:
     * $user->vendor        → Get vendor details (returns null if not a vendor)
     * $user->vendor->business_name → Get vendor's store name
     */
    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    /**
     * RELATIONSHIP: User has many Orders (as customer)
     *
     * USAGE:
     * $user->orders        → Get all orders placed by this customer
     * $user->orders()->count() → How many orders?
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * RELATIONSHIP: User has one Cart (shopping basket)
     *
     * WHY HasOne not HasMany?
     * Each customer has only ONE active cart at a time.
     *
     * USAGE:
     * $user->cart          → Get current shopping cart
     * $user->cart->items   → Get products in cart
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * RELATIONSHIP: User has many Reviews (product reviews written)
     *
     * USAGE:
     * $user->reviews       → Get all reviews written by this user
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ============================================
     * HELPER METHODS: Role Checking
     * ============================================
     *
     * WHY?
     * Clean code instead of checking $user->role === 'admin' everywhere
     */

    /**
     * Check if user is Admin
     *
     * USAGE:
     * if ($user->isAdmin()) {
     *     // Show admin panel
     * }
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Vendor
     *
     * USAGE:
     * if ($user->isVendor()) {
     *     // Show vendor dashboard
     * }
     */
    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    /**
     * Check if user is Customer
     *
     * USAGE:
     * if ($user->isCustomer()) {
     *     // Show shopping features
     * }
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Get user's full vendor account (if they have one)
     *
     * WHY?
     * Sometimes you need to get vendor data even if relationship is null
     *
     * USAGE:
     * $vendorAccount = $user->getVendorAccount();
     * if ($vendorAccount) {
     *     echo $vendorAccount->business_name;
     * }
     */
    public function getVendorAccount()
    {
        return $this->vendor;
    }

    /**
     * Check if user has an active vendor account
     *
     * USAGE:
     * if ($user->hasVendorAccount()) {
     *     // User is a verified vendor
     * }
     */
    public function hasVendorAccount(): bool
    {
        return $this->vendor !== null && $this->vendor->status === 'active';
    }
}

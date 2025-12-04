<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'compare_price',
        'stock',
        'low_stock_threshold',
        'status',
        'views_count',
        'sales_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    // Product belongs to Vendor
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // Product belongs to Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Product has many Images
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // Product has many Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Product has many Cart Items
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Check if product is active and in stock
    public function isAvailable(): bool
    {
        return $this->status === 'active' && $this->stock > 0;
    }

    // Check if stock is low
    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }
}

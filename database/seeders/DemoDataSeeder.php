<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\VendorPayout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. CREATE USERS (Customers + Vendors)
        // ============================================

        // Create customer users
        $customer1 = User::create([
            'name' => 'John Customer',
            'email' => 'john@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $customer2 = User::create([
            'name' => 'Sarah Buyer',
            'email' => 'sarah@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create vendor users
        $vendorUser1 = User::create([
            'name' => 'TechStore Owner',
            'email' => 'vendor1@vendor.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        $vendorUser2 = User::create([
            'name' => 'Fashion Hub Owner',
            'email' => 'vendor2@vendor.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        $vendorUser3 = User::create([
            'name' => 'Books Paradise Owner',
            'email' => 'vendor3@vendor.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        // ============================================
        // 2. CREATE VENDOR ACCOUNTS
        // ============================================

        $vendor1 = Vendor::create([
            'user_id' => $vendorUser1->id,
            'business_name' => 'TechStore Electronics',
            'slug' => 'techstore-electronics',
            'description' => 'Your one-stop shop for all electronics and gadgets.',
            'business_email' => 'contact@techstore.com',
            'business_phone' => '+1234567890',
            'business_address' => '123 Tech Street, Silicon Valley, CA',
            'commission_rate' => 15.00,  // 15% commission
            'status' => 'active',
            'total_earnings' => 5000.00,
            'available_balance' => 2000.00,
            'total_sales' => 50,
            'performance_score' => 4.5,
            'approved_at' => now()->subDays(30),
        ]);

        $vendor2 = Vendor::create([
            'user_id' => $vendorUser2->id,
            'business_name' => 'Fashion Hub',
            'slug' => 'fashion-hub',
            'description' => 'Trendy fashion for everyone.',
            'business_email' => 'info@fashionhub.com',
            'business_phone' => '+0987654321',
            'business_address' => '456 Fashion Ave, New York, NY',
            'commission_rate' => 18.00,  // 18% commission
            'status' => 'active',
            'total_earnings' => 3000.00,
            'available_balance' => 1500.00,
            'total_sales' => 30,
            'performance_score' => 4.2,
            'approved_at' => now()->subDays(45),
        ]);

        $vendor3 = Vendor::create([
            'user_id' => $vendorUser3->id,
            'business_name' => 'Books Paradise',
            'slug' => 'books-paradise',
            'description' => 'Every book you can imagine.',
            'business_email' => 'hello@booksparadise.com',
            'business_phone' => '+1122334455',
            'business_address' => '789 Library Road, Boston, MA',
            'commission_rate' => 10.00,  // 10% commission
            'status' => 'pending',  // Not yet approved!
            'total_earnings' => 0,
            'available_balance' => 0,
            'total_sales' => 0,
            'performance_score' => 0,
            'approved_at' => null,
        ]);

        // ============================================
        // 3. CREATE CATEGORIES
        // ============================================

        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $laptops = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Portable computers',
            'parent_id' => $electronics->id,  // Subcategory
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $phones = Category::create([
            'name' => 'Phones',
            'slug' => 'phones',
            'description' => 'Mobile phones and smartphones',
            'parent_id' => $electronics->id,  // Subcategory
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Clothing and accessories',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $books = Category::create([
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books of all genres',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // ============================================
        // 4. CREATE PRODUCTS
        // ============================================

        // TechStore products
        $product1 = Product::create([
            'vendor_id' => $vendor1->id,
            'category_id' => $laptops->id,
            'name' => 'MacBook Pro 16"',
            'slug' => 'macbook-pro-16',
            'sku' => 'TECH-MBP-001',
            'description' => 'Powerful laptop for professionals. M3 chip, 16GB RAM, 512GB SSD.',
            'price' => 2499.99,
            'compare_price' => 2799.99,
            'stock' => 10,
            'low_stock_threshold' => 3,
            'status' => 'active',
            'views_count' => 150,
            'sales_count' => 5,
        ]);

        $product2 = Product::create([
            'vendor_id' => $vendor1->id,
            'category_id' => $phones->id,
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'sku' => 'TECH-IP15-001',
            'description' => 'Latest iPhone with titanium design. 256GB storage.',
            'price' => 1199.99,
            'compare_price' => 1299.99,
            'stock' => 25,
            'low_stock_threshold' => 5,
            'status' => 'active',
            'views_count' => 300,
            'sales_count' => 15,
        ]);

        $product3 = Product::create([
            'vendor_id' => $vendor1->id,
            'category_id' => $electronics->id,
            'name' => 'AirPods Pro',
            'slug' => 'airpods-pro',
            'sku' => 'TECH-APP-001',
            'description' => 'Noise cancelling wireless earbuds.',
            'price' => 249.99,
            'compare_price' => 299.99,
            'stock' => 50,
            'low_stock_threshold' => 10,
            'status' => 'active',
            'views_count' => 200,
            'sales_count' => 20,
        ]);

        // Fashion Hub products
        $product4 = Product::create([
            'vendor_id' => $vendor2->id,
            'category_id' => $fashion->id,
            'name' => 'Designer Leather Jacket',
            'slug' => 'designer-leather-jacket',
            'sku' => 'FASH-LJ-001',
            'description' => 'Premium genuine leather jacket. Available in black and brown.',
            'price' => 399.99,
            'compare_price' => 599.99,
            'stock' => 15,
            'low_stock_threshold' => 3,
            'status' => 'active',
            'views_count' => 80,
            'sales_count' => 8,
        ]);

        $product5 = Product::create([
            'vendor_id' => $vendor2->id,
            'category_id' => $fashion->id,
            'name' => 'Summer Dress Collection',
            'slug' => 'summer-dress',
            'sku' => 'FASH-SD-001',
            'description' => 'Light and comfortable summer dress. Multiple colors.',
            'price' => 79.99,
            'compare_price' => 99.99,
            'stock' => 2,  // Low stock!
            'low_stock_threshold' => 5,
            'status' => 'active',
            'views_count' => 120,
            'sales_count' => 25,
        ]);

        // Books Paradise products (vendor not approved yet, but has products)
        $product6 = Product::create([
            'vendor_id' => $vendor3->id,
            'category_id' => $books->id,
            'name' => 'Laravel for Beginners',
            'slug' => 'laravel-beginners',
            'sku' => 'BOOK-LAR-001',
            'description' => 'Complete guide to Laravel framework. 500 pages.',
            'price' => 49.99,
            'compare_price' => 59.99,
            'stock' => 100,
            'low_stock_threshold' => 10,
            'status' => 'draft',  // Not active since vendor not approved
            'views_count' => 0,
            'sales_count' => 0,
        ]);

        // ============================================
        // 5. CREATE ORDERS
        // ============================================

        // Order 1: John bought from TechStore
        $order1 = Order::create([
            'user_id' => $customer1->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'completed',
            'subtotal' => 1449.98,
            'shipping_cost' => 20.00,
            'tax' => 130.50,
            'total' => 1600.48,
            'payment_method' => 'stripe',
            'payment_status' => 'paid',
            'shipping_address' => json_encode([
                'street' => '123 Main St',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip' => '90001',
            ]),
            'notes' => 'Please deliver between 9 AM - 5 PM',
            'created_at' => now()->subDays(5),
        ]);

        // Order items for Order 1
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product2->id,  // iPhone
            'vendor_id' => $vendor1->id,
            'quantity' => 1,
            'price' => 1199.99,
            'vendor_earnings' => 1019.99,  // After 15% commission
            'admin_commission' => 180.00,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product3->id,  // AirPods
            'vendor_id' => $vendor1->id,
            'quantity' => 1,
            'price' => 249.99,
            'vendor_earnings' => 212.49,  // After 15% commission
            'admin_commission' => 37.50,
        ]);

        // Order 2: Sarah bought from multiple vendors
        $order2 = Order::create([
            'user_id' => $customer2->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'processing',
            'subtotal' => 479.98,
            'shipping_cost' => 15.00,
            'tax' => 43.20,
            'total' => 538.18,
            'payment_method' => 'paypal',
            'payment_status' => 'paid',
            'shipping_address' => json_encode([
                'street' => '456 Oak Ave',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
            ]),
            'created_at' => now()->subDays(2),
        ]);

        // Sarah bought from both TechStore and Fashion Hub
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product4->id,  // Leather Jacket from Fashion Hub
            'vendor_id' => $vendor2->id,
            'quantity' => 1,
            'price' => 399.99,
            'vendor_earnings' => 327.99,  // After 18% commission
            'admin_commission' => 72.00,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product5->id,  // Summer Dress from Fashion Hub
            'vendor_id' => $vendor2->id,
            'quantity' => 1,
            'price' => 79.99,
            'vendor_earnings' => 65.59,  // After 18% commission
            'admin_commission' => 14.40,
        ]);

        // ============================================
        // 6. CREATE REVIEWS
        // ============================================

        Review::create([
            'product_id' => $product2->id,
            'user_id' => $customer1->id,
            'rating' => 5,
            'comment' => 'Amazing phone! Super fast and the camera is incredible.',
            'is_verified' => true,  // John actually bought this
        ]);

        Review::create([
            'product_id' => $product4->id,
            'user_id' => $customer2->id,
            'rating' => 4,
            'comment' => 'Great quality leather, but runs a bit small.',
            'is_verified' => true,  // Sarah actually bought this
        ]);

        Review::create([
            'product_id' => $product1->id,
            'user_id' => $customer2->id,
            'rating' => 5,
            'comment' => 'Best laptop I\'ve ever owned!',
            'is_verified' => false,  // Sarah didn't buy this
        ]);

        // ============================================
        // 7. CREATE VENDOR PAYOUT REQUESTS
        // ============================================

        VendorPayout::create([
            'vendor_id' => $vendor1->id,
            'amount' => 1500.00,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
            'payment_details' => json_encode([
                'bank_name' => 'Bank of America',
                'account_number' => '****1234',
            ]),
            'reference' => 'PAY-' . strtoupper(Str::random(10)),
            'approved_at' => now()->subDays(3),
            'paid_at' => now()->subDays(2),
            'notes' => 'Monthly payout - approved',
        ]);

        VendorPayout::create([
            'vendor_id' => $vendor2->id,
            'amount' => 500.00,
            'status' => 'pending',
            'payment_method' => 'paypal',
            'payment_details' => json_encode([
                'paypal_email' => 'fashionhub@paypal.com',
            ]),
            'notes' => 'Requesting weekly payout',
        ]);

        VendorPayout::create([
            'vendor_id' => $vendor1->id,
            'amount' => 300.00,
            'status' => 'rejected',
            'payment_method' => 'bank_transfer',
            'notes' => 'Rejected - Minimum payout amount not met',
        ]);

        echo "\n✅ Demo data created successfully!\n\n";
        echo "📧 Login Credentials:\n";
        echo "------------------------\n";
        echo "Admin: admin@admin.com / password\n";
        echo "Vendor 1: vendor1@vendor.com / password\n";
        echo "Vendor 2: vendor2@vendor.com / password\n";
        echo "Vendor 3: vendor3@vendor.com / password (pending approval)\n";
        echo "Customer 1: john@customer.com / password\n";
        echo "Customer 2: sarah@customer.com / password\n\n";
    }
}

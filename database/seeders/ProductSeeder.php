<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user for business_id
        $user = User::first();
        if (!$user) {
            return;
        }

        // Get or create default category, brand, and unit
        $category = Category::firstOrCreate([
            'name' => 'Electronics',
            'business_id' => $user->business_id
        ], [
            'name' => 'Electronics',
            'description' => 'Electronic products',
            'business_id' => $user->business_id
        ]);

        $brand = Brand::firstOrCreate([
            'name' => 'Generic',
            'business_id' => $user->business_id
        ], [
            'name' => 'Generic',
            'description' => 'Generic brand',
            'business_id' => $user->business_id
        ]);

        $unit = Unit::firstOrCreate([
            'name' => 'Piece',
            'business_id' => $user->business_id
        ], [
            'name' => 'Piece',
            'description' => 'Piece unit',
            'business_id' => $user->business_id
        ]);

        $products = [
            [
                'name' => 'Laptop Dell XPS 13',
                'slug' => 'laptop-dell-xps-13',
                'sku' => 'LAP001',
                'barcode' => '1234567890123',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'unit_id' => $unit->id,
                'description' => 'High-performance laptop',
                'status' => 'active',
                'user_id' => $user->id,
                'business_id' => $user->business_id,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'sku' => 'PHN001',
                'barcode' => '9876543210987',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'unit_id' => $unit->id,
                'description' => 'Latest iPhone model',
                'status' => 'active',
                'user_id' => $user->id,
                'business_id' => $user->business_id,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'sku' => 'PHN002',
                'barcode' => '4567891230456',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'unit_id' => $unit->id,
                'description' => 'Android flagship phone',
                'status' => 'active',
                'user_id' => $user->id,
                'business_id' => $user->business_id,
            ],
            [
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'sku' => 'LAP002',
                'barcode' => '7891234560789',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'unit_id' => $unit->id,
                'description' => 'Apple MacBook Pro with M3 chip',
                'status' => 'active',
                'user_id' => $user->id,
                'business_id' => $user->business_id,
            ],
            [
                'name' => 'iPad Air',
                'slug' => 'ipad-air',
                'sku' => 'TAB001',
                'barcode' => '3210987654321',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'unit_id' => $unit->id,
                'description' => 'Apple iPad Air tablet',
                'status' => 'active',
                'user_id' => $user->id,
                'business_id' => $user->business_id,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(['sku' => $productData['sku']], $productData);
        }
    }
}

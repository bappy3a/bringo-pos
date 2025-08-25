<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;

class Product extends Model
{
    //
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check() && empty($model->business_id)) {
                $model->business_id = auth()->user()->business_id;
            }
        });
        static::deleting(function ($product) {
            // Check if product has purchase details
            if ($product->purchaseDetails()->exists()) {
                throw new \Exception('Cannot delete product with existing purchase records.');
            }
        });
    }
    
    public function scopeForUserBusiness($query)
    {
        return $query->where('business_id', auth()->user()->business_id);
    }

    /**
     * Existing Relations
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    /**
     * Get the user that owns the product
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    /**
     * Get the user that owns the product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Purchase Relations
     */
    
    /**
     * Get all purchase details for the product
     */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }
     /**
     * Get all purchases for the product through purchase details
     */
    public function purchases()
    {
        return $this->hasManyThrough(Purchase::class, PurchaseDetails::class, 'product_id', 'id', 'id', 'purchase_id');
    }
    /**
     * Get purchase details for current business only
     */
    public function businessPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class)
            ->where('business_id', auth()->user()->business_id ?? 0);
    }
    /**
     * Get the latest purchase detail for the product
     */
    public function latestPurchaseDetail()
    {
        return $this->hasOne(PurchaseDetails::class)->latest();
    }

    /**
     * Get the latest purchase detail for current business
     */
    public function latestBusinessPurchaseDetail()
    {
        return $this->hasOne(PurchaseDetails::class)
            ->where('business_id', auth()->user()->business_id ?? 0)
            ->latest();
    }
    /**
     * Computed Attributes
     */

    /**
     * Get total stock quantity for the product
     */
    public function getTotalStockAttribute()
    {
        return $this->purchaseDetails()
            ->where('business_id', auth()->user()->business_id ?? 0)
            ->sum('number_of_unsell');
    }

    /**
     * Get latest purchase price for the product
     */
    public function getLatestPurchasePriceAttribute()
    {
        $latestDetail = $this->latestBusinessPurchaseDetail;
        return $latestDetail ? $latestDetail->purchase_price : 0;
    }
/**
     * Get latest selling price for the product
     */
    public function getLatestSellingPriceAttribute()
    {
        $latestDetail = $this->latestBusinessPurchaseDetail;
        return $latestDetail ? $latestDetail->selling_price : 0;
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute()
    {
        return $this->total_stock > 0;
    }

    /**
     * Check if product is low in stock
     */
    public function getLowStockAttribute()
    {
        return $this->alert_quantity && $this->total_stock <= $this->alert_quantity;
    }

    /**
     * Get total purchase value for the product
     */
    public function getTotalPurchaseValueAttribute()
    {
        return $this->purchaseDetails()
            ->where('business_id', auth()->user()->business_id ?? 0)
            ->sum('total');
    }

    /**
     * Get average purchase price for the product
     */
    public function getAveragePurchasePriceAttribute()
    {
        $details = $this->purchaseDetails()
            ->where('business_id', auth()->user()->business_id ?? 0)
            ->get();
            
        if ($details->isEmpty()) {
            return 0;
        }

        $totalValue = $details->sum(function ($detail) {
            return $detail->purchase_price * $detail->quantity;
        });
        
        $totalQuantity = $details->sum('quantity');
        
        return $totalQuantity > 0 ? $totalValue / $totalQuantity : 0;
    }

    /**
     * Get the product image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->images) {
            return asset('storage/' . $this->images);
        }
        
        return asset('images/default-product.png'); // Default image
    }

    /**
     * Query Scopes
     */

    /**
     * Scope to get products with stock information
     */
    public function scopeWithStock($query, $businessId = null)
    {
        $businessId = $businessId ?? auth()->user()->business_id ?? 0;

        return $query->addSelect([
            'total_stock' => PurchaseDetails::select(\DB::raw('COALESCE(SUM(number_of_unsell), 0)'))
                ->whereColumn('product_id', 'products.id')
                ->where('business_id', $businessId),
                
            'latest_purchase_price' => PurchaseDetails::select('purchase_price')
                ->whereColumn('product_id', 'products.id')
                ->where('business_id', $businessId)
                ->latest()
                ->limit(1),
                
            'latest_selling_price' => PurchaseDetails::select('selling_price')
                ->whereColumn('product_id', 'products.id')
                ->where('business_id', $businessId)
                ->latest()
                ->limit(1)
        ]);
    }

    /**
     * Scope to get products that are in stock
     */
    public function scopeInStock($query, $businessId = null)
    {
        $businessId = $businessId ?? auth()->user()->business_id ?? 0;

        return $query->whereHas('purchaseDetails', function ($q) use ($businessId) {
            $q->where('business_id', $businessId)
              ->where('number_of_unsell', '>', 0);
        });
    }

    /**
     * Scope to get products that are low in stock
     */
    public function scopeLowStock($query, $businessId = null)
    {
        $businessId = $businessId ?? auth()->user()->business_id ?? 0;

        return $query->whereNotNull('alert_quantity')
            ->whereHas('purchaseDetails', function ($q) use ($businessId) {
                $q->where('business_id', $businessId)
                  ->havingRaw('SUM(number_of_unsell) <= products.alert_quantity');
            });
    }

    /**
     * Scope to get products that are out of stock
     */
    public function scopeOutOfStock($query, $businessId = null)
    {
        $businessId = $businessId ?? auth()->user()->business_id ?? 0;

        return $query->whereDoesntHave('purchaseDetails', function ($q) use ($businessId) {
            $q->where('business_id', $businessId)
              ->where('number_of_unsell', '>', 0);
        });
    }

    /**
     * Get total unsold units across all purchases for current business
     */
    public function getTotalUnsellAttribute()
    {
        $businessId = auth()->user()->business_id ?? 0;
        return (int) $this->purchaseDetails()
            ->where('business_id', $businessId)
            ->sum('number_of_unsell');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
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
    }
    
    public function scopeForUserBusiness($query)
    {
        return $query->where('business_id', auth()->user()->business_id);
    }

    /**
     * Get the product for this purchase detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the purchase for this purchase detail.
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

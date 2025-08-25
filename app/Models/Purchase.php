<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
     * Get the purchase details for this purchase.
     */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the contact (supplier) for this purchase.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the user who created this purchase.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

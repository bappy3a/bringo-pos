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
    }
    
    public function scopeForUserBusiness($query)
    {
        return $query->where('business_id', auth()->user()->business_id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

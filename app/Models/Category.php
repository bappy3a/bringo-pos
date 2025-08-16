<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

}

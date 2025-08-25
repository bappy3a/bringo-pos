<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountTransaction extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->business_id)) {
                $model->business_id = Auth::user()->business_id;
            }
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
}



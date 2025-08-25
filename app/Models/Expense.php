<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
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

    public function scopeForUserBusiness($query)
    {
        return $query->where('business_id', Auth::user()->business_id);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

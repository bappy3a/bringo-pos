<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'return_quantity' => 'required|array',
            'return_quantity.*' => 'required|numeric|min:1',
            'reason' => 'nullable|string|max:500',
        ];
    }
}

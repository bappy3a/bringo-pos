<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'barcode_type' => 'required|in:code_128,code_39,ean_13,ean_8,upc_a,upc_e',
            'quantity_alert' => 'nullable|integer',
            'not_for_selling' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'supplier_id' => 'nullable|exists:contacts,id',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
        ];
    }
}

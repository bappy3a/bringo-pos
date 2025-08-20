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
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'barcode_type' => 'required|in:code_128,code_39,ean_13,ean_8,upc_a,upc_e',
            'alert_quantity' => 'nullable|integer',
            'not_for_selling' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'add_opening_stock' => 'nullable|boolean',
            'supplier_id' => 'required_if:add_opening_stock,1|exists:contacts,id',
            'quantity' => 'required_if:add_opening_stock,1|numeric|min:0',
            'purchase_price' => 'required_if:add_opening_stock,1|numeric|min:0',
            'selling_price' => 'required_if:add_opening_stock,1|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a product name.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists' => 'The selected brand is invalid.',
            'unit_id.required' => 'Please select a unit.',
            'unit_id.exists' => 'The selected unit is invalid.',
            'barcode_type.required' => 'Please select a barcode type.',
            'barcode_type.in' => 'The selected barcode type is invalid.',
            'not_for_selling.required' => 'Please specify if the product is for selling.',
            'not_for_selling.boolean' => 'Invalid value for the selling option.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2MB.',
            'alert_quantity.integer' => 'The quantity alert must be an integer.',

            'add_opening_stock.boolean' => 'Invalid value for Add Opening Stock.',
            'supplier_id.required_if' => 'The supplier is required when Add Opening Stock is checked.',
            'supplier_id.exists' => 'The selected supplier is invalid.',
            'quantity.required_if' => 'The quantity is required when Add Opening Stock is checked.',
            'quantity.numeric' => 'The quantity must be a number.',
            'quantity.min' => 'The quantity must be at least 0.',
            'purchase_price.required_if' => 'The purchase price is required when Add Opening Stock is checked.',
            'purchase_price.numeric' => 'The purchase price must be a number.',
            'purchase_price.min' => 'The purchase price must be at least 0.',
            'selling_price.required_if' => 'The selling price is required when Add Opening Stock is checked.',
            'selling_price.numeric' => 'The selling price must be a number.',
            'selling_price.min' => 'The selling price must be at least 0.',
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
        $productId = $this->route('product'); // Get the product ID from the route

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)
            ],
            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)
            ],
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'barcode_type' => 'required|in:code_128,code_39,ean_13,ean_8,upc_a,upc_e',
            'alert_quantity' => 'nullable|integer|min:0',
            'not_for_selling' => 'required|boolean',
            'selling_price_tax_type' => 'required|in:inclusive,exclusive',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:1000',
            'supplier_id' => 'nullable|exists:contacts,id',
            'quantity' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be a string.',
            'name.max' => 'Product name cannot exceed 255 characters.',
            'sku.unique' => 'This SKU is already taken.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'brand_id.required' => 'Please select a brand.',
            'brand_id.exists' => 'Selected brand is invalid.',
            'unit_id.required' => 'Please select a unit.',
            'unit_id.exists' => 'Selected unit is invalid.',
            'barcode_type.required' => 'Please select a barcode type.',
            'barcode_type.in' => 'Invalid barcode type selected.',
            'alert_quantity.integer' => 'Alert quantity must be a number.',
            'alert_quantity.min' => 'Alert quantity cannot be negative.',
            'not_for_selling.required' => 'Please specify if this product is for selling.',
            'selling_price_tax_type.required' => 'Please select a tax type.',
            'selling_price_tax_type.in' => 'Invalid tax type selected.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2MB.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'supplier_id.exists' => 'Selected supplier is invalid.',
            'quantity.integer' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity cannot be negative.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',
        ];
    }
}

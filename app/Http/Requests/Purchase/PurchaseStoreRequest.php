<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
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
            "contact_id"=> "required|exists:contacts,id",
            "account_id"=> "nullable|exists:accounts,id",
            "product_id"=> "required|array",
            "product_id.*"=> "required|exists:products,id",
            "quantity"=> "required|array",
            "quantity.*"=> "required|numeric",
            "purchase_price"=> "required|array",
            "purchase_price.*"=> "required|numeric",
            "selling_price"=> "required|array",
            "selling_price.*"=> "required|numeric",
            "date" => "required|date_format:d-m-Y",
            "reference_no" => "nullable|string|max:255",
            "note" => "nullable|string",
            "discount" => "nullable|array",
            "discount.*" => "nullable|numeric|min:0",
            "tax" => "nullable|array",
            "tax.*" => "nullable|numeric|min:0",
            "transaction_id" => "nullable|string|max:255",
        ];
    }
}

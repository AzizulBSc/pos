<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update_product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product'); 
        return [
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $productId,
            'sku' => 'required|string|max:255|unique:products,sku,' . $productId,
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'nullable|exists:units,id',
            'price' => 'required|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percentage"|required_with:discount',
            'discount' => 'nullable|numeric|min:0|required_with:discount_type',
            'purchase_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'expire_date' => 'nullable|date|after:today',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ];
    }
}

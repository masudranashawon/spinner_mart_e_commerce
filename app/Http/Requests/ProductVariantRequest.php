<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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

        if ($this->method() === 'PUT') {
            // Update: single variant
            return [
                'edit_size' => 'nullable|exists:sizes,id',
                'edit_color' => 'nullable|exists:colors,id',
                'edit_buying_price' => 'required|numeric|min:0',
                'edit_selling_price' => 'required|numeric|min:0',
            ];
        }

        // Bulk create: multiple variants
        return [
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|max:255|unique:product_variants,sku_code',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.size_id' => 'nullable|exists:sizes,id',
            'variants.*.buying_price' => 'required|numeric|min:0',
            'variants.*.selling_price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'variants.required' => 'Please add at least one variant.',
            'variants.*.sku.required' => 'SKU is required for all variants.',
            'variants.*.buying_price.required' => 'Buying Price is required for all variants.',
            'variants.*.selling_price.required' => 'Selling Price is required for all variants.',
        ];
    }
}

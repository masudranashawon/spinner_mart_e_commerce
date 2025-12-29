<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $sku = $this->method() === "PUT" ? "required|string|max:255|unique:products,sku_code," . $this->sku_code->id : "required|string|max:255|unique:products,sku_code";

        return [
            /* =========================
                Products table
             ========================= */
            'name' => "required|string|max:255",
            'short_description' => "required",
            'product_sku' =>  $sku,
            'category' => "required|exists:categories,id",
            'sub_category' => "required|exists:sub_categories,id",
            'buying_price' => "nullable|numeric|min:0",
            'selling_price' => "required|numeric|min:0",
            'thumbnail' => "required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "image.max" => "The image size must not exceed 2MB.",
            "category.required" => "The category field is required.",
            "image.mimes" => "Only jpeg, png, jpg, gif, webp, svg files are allowed.",
        ];
    }
}

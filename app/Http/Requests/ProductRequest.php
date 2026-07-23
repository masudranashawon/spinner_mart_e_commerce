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

        $sku = $this->method() === "PUT" ? "required|string|max:255|unique:products,sku_code," . $this->product->id : "required|string|max:255|unique:products,sku_code";
        $thumbnail = $this->method() === "PUT" ? "nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048" : "required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048";

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
            'brand' => 'nullable|exists:brands,id',
            'thumbnail' =>  $thumbnail,
            'gallery_images.*' => 'nullable|image|max:2048',
            'deleted_gallery_ids' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'is_deal_of_the_day' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
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

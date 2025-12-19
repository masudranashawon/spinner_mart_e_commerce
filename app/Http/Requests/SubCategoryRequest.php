<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            "name" =>  "required|string|max:255|unique:sub_categories,name",
            "category_id" => "required|exists:categories,id",
            "slug" => "nullable|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "image.max" => "The image size must not exceed 2MB.",
            "category_id.required" => "The category field is required.",
            "image.mimes" => "Only jpeg, png, jpg, gif, webp, svg files are allowed.",
        ];
    }
}

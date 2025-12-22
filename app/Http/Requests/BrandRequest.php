<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $slug = $this->method() === "PUT" ? "required|string|max:255|unique:brands,slug," . $this->brand->id : "nullable|string|max:255|unique:brands,slug";

        return [
            "name" =>   "required|string|max:255",
            "slug" =>  $slug,
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "image.max" => "The image size must not exceed 2MB.",
            "image.mimes" => "Only jpeg, png, jpg, gif, webp, svg files are allowed.",
        ];
    }
}

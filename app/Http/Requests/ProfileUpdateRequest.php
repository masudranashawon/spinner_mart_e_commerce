<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            "thumbnail" => "nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "thumbnail.max" => "The image size must not exceed 2MB.",
            "thumbnail.mimes" => "Only jpeg, png, jpg, gif, webp, svg files are allowed.",
        ];
    }
}

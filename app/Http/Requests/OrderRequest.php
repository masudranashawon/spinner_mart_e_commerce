<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethodEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            // Billing Address 
            "name" => "required|string|max:255",
            "country" => "required|string|max:255",
            "city" => "required|string|max:255",
            "postCode" => "required|string|max:50",
            "company" => "nullable|string|max:255",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:20",
            "address" => "required|string",
            "message" => "nullable|string",

            // Shipping Address 
            "different_shipping" => "nullable|boolean",
            "shippingName" => "required_if:different_shipping,1|nullable|string|max:255",
            "shippingCountry" => "required_if:different_shipping,1|nullable|string|max:255",
            "shippingCity" => "required_if:different_shipping,1|nullable|string|max:255",
            "shippingPostCode" => "required_if:different_shipping,1|nullable|string|max:50",
            "shippingCompany" => "nullable|string|max:255",
            "shippingEmail" => "nullable|email|max:255",
            "shippingPhone" => "required_if:different_shipping,1|nullable|string|max:20",
            "shippingAddress" => "required_if:different_shipping,1|nullable|string",
            "shippingMessage" => "nullable|string",

            // Order
            "deliveryCharge" => "required|numeric",
            "payment_method" => ["required", Rule::enum(PaymentMethodEnums::class),],
            "note" => "nullable|string",
        ];
    }
    public function messages(): array
    {
        return [
            // Billing Address
            "name.required" => "Billing name is required.",
            "country.required" => "Billing country is required.",
            "city.required" => "Billing city is required.",
            "postCode.required" => "Billing post code is required.",
            "phone.required" => "Billing phone number is required.",
            "address.required" => "Billing address is required.",
            "email.required" => "Billing email is required.",
            "email.email" => "Please enter a valid billing email address.",

            // Shipping Address
            "shippingName.required_if" => "Shipping name is required.",
            "shippingCountry.required_if" => "Shipping country is required.",
            "shippingCity.required_if" => "Shipping city is required.",
            "shippingPostCode.required_if" => "Shipping post code is required.",
            "shippingPhone.required_if" => "Shipping phone number is required.",
            "shippingAddress.required_if" => "Shipping address is required.",
            "shippingEmail.email" => "Please enter a valid shipping email address.",

            // Order
            "deliveryCharge.required" => "Delivery charge is required.",
            "deliveryCharge.numeric" => "Delivery charge must be a valid number.",
            "payment_method.required" => "Please select a payment method.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartOrderRequest extends FormRequest
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
            "user_id" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "total" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "delivery" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "name" => "required|string",
            "email" => "required|string|email",
            "country" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "address" => "required|min:10",
            "phone" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            "delivery_option" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "additional_note" => "nullable",
            "payment_option" => "required|regex:/^([0-9\s\-\+\(\)]*)$/"
        ];
    }
}

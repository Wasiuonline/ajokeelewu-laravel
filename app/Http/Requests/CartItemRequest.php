<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
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
            "item_id" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "size_id" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "price" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "quantity" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
        ];
    }
}

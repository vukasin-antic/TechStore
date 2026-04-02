<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => 'required|string|regex:/^[a-zA-ZÀ-ž\s]+$/|min:2|max:15',
            'last_name' => 'required|string|regex:/^[a-zA-ZÀ-ž\s]+$/|min:2|max:15',
            'address' => 'required|string',
            'city' => 'required|string|regex:/^[a-zA-ZÀ-ž\s]+$/|min:2|max:15',
            'country' => 'required|string|regex:/^[a-zA-ZÀ-ž\s]+$/|min:2|max:15',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'notes' => 'nullable|string',
        ];
    }
}

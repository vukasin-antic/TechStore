<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'first_name' => 'required|string|regex:/^[a-zA-ZÀ-ž\s]+$/|min:2|max:15',
            'last_name' => 'required|string|regex:/^[a-zA-ZÀ-ž]+$/|min:2|max:15',
            'email' => 'required|email|unique:users,email,' . session('user')['id'],
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email is invalid.',
            'email.unique' => 'Email already exists.',
        ];
    }
}

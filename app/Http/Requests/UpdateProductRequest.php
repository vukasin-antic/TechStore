<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'specs' => 'required|array|min:1',
            'specs.*.type_id' => 'required|exists:specification_types,id',
            'specs.*.value' => 'required|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'price.required' => 'Product price is required',
            'description.required' => 'Product description is required',
            'stock.required' => 'Product stock is required',
            'category_id.required' => 'Please select a category',
            'brand_id.required' => 'You must choose a brand',
            'specs.required' => 'Please add at least one specification',
            'specs.min' => 'Please add at least one specification',
            'specs.*.type_id.required' => 'Please select a specification type',
            'specs.*.value.required' => 'Please enter a value for the specification',
        ];
    }
}

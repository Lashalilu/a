<?php

namespace App\Http\Requests\Products;

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
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'details' => 'sometimes|array',
            'details.*.detail_key' => 'required_with:details|array',
            'details.*.detail_key.*' => 'required|string|max:255',
            'details.*.value' => 'required_with:details|array',
            'details.*.value.*' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}

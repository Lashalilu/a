<?php

namespace App\Http\Requests\ProductTags;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductTagsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'tag_id' => 'required|exists:tags,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }
}
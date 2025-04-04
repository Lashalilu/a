<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'stock' => $this->stock,
            'translations' => $this->translations->mapWithKeys(function ($translation) {
                return [$translation->locale => [
                    'name' => $translation->name,
                    'description' => $translation->description,
                ]];
            }),
        ];
    }
}

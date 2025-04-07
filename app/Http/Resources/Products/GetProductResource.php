<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\ProductAdditionalDetailResource;

class GetProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'stock' => $this->stock,
            'created_at' => $this->created_at,
            'additional_details' => ProductAdditionalDetailResource::collection($this->additionDetails),
            'category' => $this->category?->name,
            'category_id' => $this->category_id,
            'tags' => ProductTagsResource::collection($this->productTags),
        ];
    }
}

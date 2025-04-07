<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use App\Models\ProductTags;
use App\Http\Requests\ProductTags\StoreProductTagsRequest;
class ProductTagsController extends Controller
{
    public function store(StoreProductTagsRequest $request)
    {
        $data = $request->validated();

        ProductTags::create($data);

        return response()->json(['message' => 'Product tag created successfully']);
    }

    public function destroy(ProductTags $productTag)
    {
        $productTag->delete();

        return response()->json(['message' => 'Product tag deleted successfully']);
    }

    public function update(StoreProductTagsRequest $request, ProductTags $productTag)
    {
        $data = $request->validated();

        $productTag->update($data);

        return response()->json(['message' => 'Product tag updated successfully']);
    }
}

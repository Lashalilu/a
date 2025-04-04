<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\GetProductRequest;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\Products\GetProductResource;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Support\Facades\DB;
use App\Jobs\LogUserSearch;
use App\Services\Products\IndexProductService;
use App\Http\Resources\Products\EditProductResource;
use Illuminate\Http\Request;
use App\Services\Products\StoreOrUpdateProductService;

class ProductController extends Controller
{
    public function __construct(protected IndexProductService $indexProductService, protected StoreOrUpdateProductService $storeOrUpdateProductService)
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(GetProductRequest $request)
    {
        $products = $this->indexProductService->index($request);

        return GetProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction(); 

        $this->storeOrUpdateProductService->store($data);

        DB::commit();

        return response()->json(["message" => "Product created successfully"]);
    }

    public function show(Product $product)
    {
        return new GetProductResource($product);
    }

    public function edit(Product $product)
    {
        $product->load('translations');

        return new EditProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        DB::beginTransaction();

        $this->storeOrUpdateProductService->update($data, $product);

        DB::commit();

        return response()->json(["message" => "Product updated successfully"]);
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        UserProduct::where('product_id', $product->id)->delete();

        $product->delete();

        DB::commit();

        return response()->json(["message" => "Product deleted successfully"]);
    }
}

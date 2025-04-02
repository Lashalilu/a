<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\GetProductRequest;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\Products\GetProductResource;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Support\Facades\DB;
use App\Jobs\LogUserSearch;
use App\Services\Products\IndexProductService;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected IndexProductService $indexProductService)
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(GetProductRequest $request)
    {
        $products = $this->indexProductService->index($request);

        // $products = Product::query() 
        // ->search($request->keyword)
        // ->authUserSmartReturn()
        // ->orderBy('id', 'desc')
        // ->paginate($request->per_page ?? 10);
        
        return GetProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        $product = Product::create($data);

        UserProduct::create([
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
        ]);

        DB::commit();

        return response()->json(
            [
                "message" => "Product created successfully",
            ]
        );
    }
}

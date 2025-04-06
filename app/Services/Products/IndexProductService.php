<?php

namespace App\Services\Products;

use App\Http\Requests\Products\GetProductRequest;
use App\Models\Product;
use App\Jobs\LogUserSearch;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class IndexProductService
{
    public function index(GetProductRequest $request)
    {
        $perPage = $request->per_page ?? 20;

        if ($request->filled('keyword')) {
            if (auth()->check()) {
                LogUserSearch::dispatch(auth()->id(), $request->keyword);
            }

            $products = Product::query()
                ->with(['additionDetails.translations', 'category.translations'])
                ->search($request->keyword)
                ->orderByDesc('id')
                ->paginate($perPage);

            return $products;
        }

        $keywordLimit = 12;
        $newestLimit = $perPage - $keywordLimit;

        $user = auth()->user();
        if ($user && $user->userSearchHistory()->exists()) {
            $keywordProducts = Product::query()
                ->with(['additionDetails.translations', 'category.translations'])
                ->authUserSmartReturn()
                ->limit($keywordLimit)
                ->get();

            $newestProducts = Product::query()
                ->with(['additionDetails.translations', 'category.translations'])
                ->whereNotIn('id', $keywordProducts->pluck('id'))
                ->orderByDesc('id')
                ->limit($newestLimit)
                ->get();

            $merged = $keywordProducts->merge($newestProducts);

            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                $merged,
                $merged->count(),
                $perPage,
                \Illuminate\Pagination\Paginator::resolveCurrentPage(),
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
        } else {
            $products = Product::query()
                ->with(['additionDetails.translations', 'category.translations'])
                ->orderByDesc('id')
                ->paginate($perPage);
        }

        return $products;
    }
}

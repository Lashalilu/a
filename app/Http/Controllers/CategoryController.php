<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Categories\IndexCategoryRequest;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Resources\Categories\IndexCategoryResource;

class CategoryController extends Controller
{
    public function index(IndexCategoryRequest $request)
    {
        $categories = Category::query()
            ->whereTranslationLike('name', '%' . $request->keyword . '%')
            ->paginate($request->per_page ?? 10);

        return IndexCategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $categoryData = ['is_active' => $data['is_active']];

        foreach ($data['name'] as $locale => $name) {
            $categoryData[$locale] = [
                'name' => $name,
                'description' => $data['description'][$locale] ?? null,
            ];
        }

        Category::create($categoryData);

        return response()->json([
            "message" => "Category created successfully",
        ]);
    }

    public function show(Category $category)
    {
        return new IndexCategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $categoryData = ['is_active' => $data['is_active']];

        foreach ($data['name'] as $locale => $name) {
            $categoryData[$locale] = [
                'name' => $name,
                'description' => $data['description'][$locale] ?? null,
            ];
        }

        $category->update($categoryData);

        return response()->json([
            "message" => "Category updated successfully",
        ]);
    }


    public function destroy(Category $category)
    {
        $category->update(['is_active' => false]);

        return response()->json([
            "message" => "Category deleted successfully",
        ]);
    }
}

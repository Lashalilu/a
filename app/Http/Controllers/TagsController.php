<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\Tags\GetTagsRequest;
use App\Http\Requests\Tags\StoreTagsRequest;
use App\Http\Resources\Tags\GetTagsResource;

class TagsController extends Controller
{
    public function index(GetTagsRequest $request)
    {
        $tags = Tag::query()
            ->when($request->keyword, function ($query) use ($request) {
                $query->whereTranslationLike('name', '%' . $request->keyword . '%')
                    ->orWhereTranslationLike('description', '%' . $request->keyword . '%');
            })->paginate($request->per_page);

        return GetTagsResource::collection($tags);
    }

    public function store(StoreTagsRequest $request)
    {
        $data = $request->validated();

        $tagData = ['is_active' => $data['is_active'], 'price' => $data['price']];

        foreach ($data['name'] as $locale => $name) {
            $tagData[$locale] = [
                'name' => $name,
                'description' => $data['description'][$locale] ?? null,
            ];
        }

        Tag::create($tagData);

        return response()->json([
            "message" => "Tag created successfully",
        ]);
    }

    public function show(Tag $tag)
    {
        return new GetTagsResource($tag);
    }

    public function update(StoreTagsRequest $request, Tag $tag)
    {
        $data = $request->validated();

        $tagData = ['is_active' => $data['is_active'], 'price' => $data['price']];

        foreach ($data['name'] as $locale => $name) {
            $tagData[$locale] = [
                'name' => $name,
                'description' => $data['description'][$locale] ?? null,
            ];
        }

        $tag->update($tagData);

        return response()->json([
            "message" => "Tag updated successfully",
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->update(['is_active' => false]);

        return response()->json([
            "message" => "Tag deleted successfully",
        ]);
    }
}

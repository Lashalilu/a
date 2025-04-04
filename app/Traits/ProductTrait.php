<?php

namespace App\Traits;

trait ProductTrait
{
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query
                ->whereTranslationLike('name', '%' . $keyword . '%')
                ->orWhereTranslationLike('description', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%')
                ->orWhere('stock', 'like', '%' . $keyword . '%')
                ->orWhereHas('additionDetails', function ($q) use ($keyword) {
                    $q->whereTranslationLike('detail_key', '%' . $keyword . '%')
                        ->orWhereTranslationLike('value', '%' . $keyword . '%');
                });
        }

        return $query;
    }

    public function scopeAuthUserSmartReturn($query)
    {
        $user = auth()->user();
        $searchKeywords = $user->userSearchHistory()
            ->selectRaw('keyword, SUM(quantity) as total_quantity')
            ->groupBy('keyword')
            ->orderByDesc('total_quantity')
            ->get();

        if ($searchKeywords->isNotEmpty()) {
            $scoreParts = [];
            foreach ($searchKeywords as $keywordRecord) {
                $keyword = $keywordRecord->keyword;
                $weight = $keywordRecord->total_quantity;
                $escaped = addslashes($keyword);
                $scoreParts[] = "IF(pt.name LIKE '%{$escaped}%' OR pt.description LIKE '%{$escaped}%', {$weight}, 0)";
            }
            $scoreSql = implode(' + ', $scoreParts);

            return $query->join('product_translations as pt', function ($join) {
                $join->on('products.id', '=', 'pt.product_id')
                    ->where('pt.locale', '=', config('app.locale'));
            })
                ->selectRaw("products.*, ({$scoreSql}) as relevance")
                ->orderByDesc('relevance')
                ->orderByDesc('products.id');
        }

        return $query;
    }
}

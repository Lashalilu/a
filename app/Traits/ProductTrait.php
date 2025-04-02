<?php

namespace App\Traits;

trait ProductTrait
{
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%')
                ->orWhere('stock', 'like', '%' . $keyword . '%');
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
                $scoreParts[] = "IF(name LIKE '%{$escaped}%' OR description LIKE '%{$escaped}%', {$weight}, 0)";
            }
            $scoreSql = implode(' + ', $scoreParts);

            return $query->selectRaw("products.*, ({$scoreSql}) as relevance")
                ->orderByDesc('relevance')
                ->orderByDesc('id');
        }

        return $query;
    }
}

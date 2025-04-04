<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\UserProduct;
use App\Models\ProductAdditionDetail;

class StoreOrUpdateProductService
{
    public function store(array $data)
    {
        $product = Product::create([
            'price' => $data['price'],
            'stock' => $data['stock'],
        ]);

        foreach ($data['name'] as $locale => $name) {
            $product->translateOrNew($locale)->name = $name;
            $product->translateOrNew($locale)->description = $data['description'][$locale] ?? '';
        }
        $product->save();

        UserProduct::create([
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
        ]);

        if (isset($data['details']) && is_array($data['details'])) {
            foreach ($data['details'] as $detail) {
                $additionDetail = new ProductAdditionDetail();
                $additionDetail->product_id = $product->id;

                foreach ($detail['detail_key'] as $locale => $translatedKey) {
                    $additionDetail->translateOrNew($locale)->detail_key = $translatedKey;
                }

                foreach ($detail['value'] as $locale => $translatedValue) {
                    $additionDetail->translateOrNew($locale)->value = $translatedValue;
                }

                $additionDetail->save();
            }
        }
    }

    public function update(array $data, Product $product)
    {
        $product->update([
            'price' => $data['price'],
            'stock' => $data['stock'],
        ]);

        foreach ($data['name'] as $locale => $name) {
            $product->translateOrNew($locale)->name = $name;
            $product->translateOrNew($locale)->description = $data['description'][$locale] ?? '';
        }

        $product->save();

        if (isset($data['details']) && is_array($data['details'])) {
            foreach ($data['details'] as $detail) {

                $additionDetail = ProductAdditionDetail::where('product_id', $product->id)->first();

                if (!$additionDetail) {
                    $additionDetail = new ProductAdditionDetail();
                    $additionDetail->product_id = $product->id;
                }

                foreach ($detail['detail_key'] as $locale => $translatedKey) {
                    $additionDetail->translateOrNew($locale)->detail_key = $translatedKey;
                }

                foreach ($detail['value'] as $locale => $translatedValue) {
                    $additionDetail->translateOrNew($locale)->value = $translatedValue;
                }

                $additionDetail->save();
            }
        }
    }
}

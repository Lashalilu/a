<?php

namespace App\Models;

use App\Traits\ProductTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\UserSearch;
use App\Models\Category;
use App\Models\ProductAdditionDetail;


class Product extends Model implements TranslatableContract
{
    use ProductTrait, Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'price',
        'stock',
        'image',
        'category_id',
    ];

    public function userSearchHistory()
    {
        return $this->hasMany(UserSearch::class);
    }

    public function additionDetails()
    {
        return $this->hasMany(ProductAdditionDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->where('is_active', 1);
    }
}

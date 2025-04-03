<?php

namespace App\Models;

use App\Traits\ProductTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use ProductTrait, Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'price',
        'stock',
        'image',
    ];

    public function userSearchHistory()
    {
        return $this->hasMany(\App\Models\UserSearch::class);
    }
}

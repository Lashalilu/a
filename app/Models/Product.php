<?php

namespace App\Models;

use App\Traits\ProductTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use ProductTrait;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function userSearchHistory()
    {
        return $this->hasMany(\App\Models\UserSearch::class);
    }
}

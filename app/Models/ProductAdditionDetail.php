<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProductAdditionDetail extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = ['product_id'];
    
    public $translatedAttributes = ['detail_key', 'value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

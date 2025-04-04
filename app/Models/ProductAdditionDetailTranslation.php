<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionDetailTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['detail_key', 'value'];
}

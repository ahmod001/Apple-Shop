<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'price',
        'discount',
        'discount_price',
        'img',
        'stock',
        'star',
        'remark',
        'category_id',
        'brand_id',
    ];
    
      function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    
    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}

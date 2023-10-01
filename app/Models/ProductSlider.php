<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSlider extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'price',
        'img',
        'product_id',
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'slug',
    'stock',
    'price',
    'actual_price',
    'discount',
    'size',
    'color',
    'description',
    'status',
    'visibility',
    'category_id',
    'brand',
    'product_code',
    'product_image',
];

}


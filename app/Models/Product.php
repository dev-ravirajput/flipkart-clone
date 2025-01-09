<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'status',
        'slug',
        'name',
        'price',
        'discount_percentage',
        'discount_price',
        'description',
        'featured_image',
        'gallery_images', // To store gallery images paths as JSON
    ];
}

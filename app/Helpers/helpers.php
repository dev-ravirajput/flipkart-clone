<?php

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;


if (!function_exists('getBrands')) {
    function getBrands($id)
    {
        return Brand::find($id);
    }
}

if (!function_exists('getSubcategory')) {
    function getSubcategory($id)
    {
        return Subcategory::find($id);
    }
}

if (!function_exists('getCategory')) {
    function getCategory($id)
    {
        return $category = Category::find($id);
    }
}
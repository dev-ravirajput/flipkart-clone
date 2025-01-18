<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;

class FlipkartController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)
        ->orderBy('discount_percentage', 'desc')
        ->take(9)
        ->get();
        $promotions = Promotion::all();
        return view('Frontend.index', compact('categories', 'products', 'promotions'));
    }

    public function productDetails($slug)
    {
       $product = Product::where('slug', $slug)->first();
       $categories = Category::where('status', 1)->get();
       return view('Frontend.product_details', compact('product', 'categories'));
    }
}

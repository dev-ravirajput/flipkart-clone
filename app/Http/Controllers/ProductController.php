<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', '1')->get();
        return view('admin.products.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validatedData = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'brand_id' => 'required|exists:brands,id',
        'status' => 'required|boolean',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
        'discount_price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'featured_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $slug = \Str::slug($request->name);
        $slugCount = Product::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }

    // Handle Featured Image
    if ($request->hasFile('featured_image')) {
        $featuredImagePath = $request->file('featured_image')->store('products/featured', 'public');
        $validatedData['featured_image'] = $featuredImagePath;
    }

    // Handle Gallery Images
    $galleryImages = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products/gallery', 'public');
            $galleryImages[] = $path;
        }
    }

    // Add gallery images as a JSON string (or use a relationship if needed)
    $validatedData['gallery_images'] = json_encode($galleryImages);
    $validatedData['slug'] = $slug;

    // Create the product
    $product = Product::create($validatedData);

    return redirect()->route('admin.products')->with('success', 'Product created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product)
    {
        $product = Product::where('slug', $product)->first();
        $product->gallery_images = json_decode($product->gallery_images, true);
        $categories = Category::where('status', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the request
    $validatedData = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'brand_id' => 'required|exists:brands,id',
        'status' => 'required|boolean',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
        'discount_price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Fetch the existing product
    $product = Product::findOrFail($id);

    // Handle Slug (keeping it the same or updating if the name is changed)
    $slug = \Str::slug($request->name);
    if ($slug !== $product->slug) {
        $slugCount = Product::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }
    }

    // Handle Featured Image Update (if a new image is uploaded)
    if ($request->hasFile('featured_image')) {
        // Delete the old featured image if it exists
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }

        // Store the new featured image
        $featuredImagePath = $request->file('featured_image')->store('products/featured', 'public');
        $validatedData['featured_image'] = $featuredImagePath;
    } else {
        // If no new featured image, keep the existing one
        $validatedData['featured_image'] = $product->featured_image;
    }

    // Handle Gallery Images Update (if new images are uploaded)
    if ($request->hasFile('images')) {
        // Delete old gallery images if they exist
        if ($product->gallery_images) {
            $oldGalleryImages = json_decode($product->gallery_images, true);
            foreach ($oldGalleryImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Store new gallery images
        $galleryImages = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('products/gallery', 'public');
            $galleryImages[] = $path;
        }

        $validatedData['gallery_images'] = json_encode($galleryImages);
    } else {
        // If no new gallery images, keep the existing ones
        $validatedData['gallery_images'] = $product->gallery_images;
    }

    // Update the product with the new data
    $validatedData['slug'] = $slug;
    $product->update($validatedData);

    return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        // Find the product by its slug or ID
        $product = Product::findOrFail($product);
    
        // Delete the featured image from storage (if it exists)
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }
    
        // Delete gallery images from storage (if they exist)
        if ($product->gallery_images) {
            $galleryImages = json_decode($product->gallery_images, true);
            foreach ($galleryImages as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    
        // Delete the product record from the database
        $product->delete();
    
        return redirect()->route('admin.products')->with('success', 'Product and related images deleted successfully!');
    }
    

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function getBrands($subcategoryId)
    {
        $brands = Brand::where('subcategory_id', $subcategoryId)->get();
        return response()->json($brands);
    }

}

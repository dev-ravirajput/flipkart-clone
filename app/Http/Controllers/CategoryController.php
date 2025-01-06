<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image (optional)
        ]);

        $slug = \Str::slug($request->name);
        $slugCount = Category::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }
    
        // Store the image if one is uploaded
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('categories', 'public');
        }
    
        // Store category data in the database
        Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
            'slug' => $slug,
        ]);
    
        // Redirect or return a response
        return redirect()->route('admin.category')->with('success', 'Category added successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image (optional)
        ]);
    
        // Generate slug
        $slug = \Str::slug($request->name);

        // Exclude the current category by using the ID in the query
        $slugCount = Category::where('slug', $slug)
                             ->where('id', '!=', $id) // Exclude the current category
                             ->count();
        
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }        
    
        // Find the category by ID
        $category = Category::find($id);
    
        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Category not found.');
        }
    
        // Store the image if one is uploaded
        $imagePath = $category->image; // Retain the existing image if none is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('categories', 'public');
        }
    
        // Update category data in the database
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $imagePath,
            'slug' => $slug,
        ]);
    
        // Redirect or return a response
        return redirect()->route('admin.category')->with('success', 'Category updated successfully!');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        // Delete related files if they exist
        if ($category->image) {
            // Delete image file from storage
            Storage::disk('public')->delete($category->image);
        }
    
        // Delete the category from the database
        $category->delete();
    
        // Redirect or return a response
        return redirect()->route('admin.category')->with('success', 'Category deleted successfully!');
    }
    
}

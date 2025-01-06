<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.subcategory.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg',
        ]);

        $slug = \Str::slug($request->name);
        $slugCount = Subcategory::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }

        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->description = $request->description;
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status;
        $subcategory->slug = $slug;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->store('subcategories', 'public');
            $subcategory->image = $imagePath;
            }
        $subcategory->save();
        return redirect()->route('admin.subcategory')->with('success', 'Subcategory created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subcategory)
    {
       $categories = Category::where('status', 1)->get();
       $subcategory = Subcategory::find($subcategory);
       return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $subcategory)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Updated validation rule
    ]);

    // Find the subcategory by ID
    $subcategory = Subcategory::find($subcategory);

    // Handle case where subcategory is not found
    if (!$subcategory) {
        return redirect()->route('admin.subcategory')->with('error', 'Subcategory not found');
    }

    // Generate the slug and check for duplicates
    $slug = \Str::slug($request->name);
    $slugCount = Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->count();
    if ($slugCount > 0) {
        $slug .= '-' . ($slugCount + 1);
    }

    // Update subcategory fields
    $subcategory->name = $request->name;
    $subcategory->description = $request->description;
    $subcategory->category_id = $request->category_id;
    $subcategory->status = $request->status;
    $subcategory->slug = $slug;

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('subcategories', 'public');
        $subcategory->image = $imagePath;
    }

    // Save the subcategory
    $subcategory->save();

    // Redirect with success message
    return redirect()->route('admin.subcategory')->with('success', 'Subcategory updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
    
        // Delete related files if they exist
        if ($subcategory->image) {
            // Delete image file from storage
            Storage::disk('public')->delete($subcategory->image);
        }
    
        // Delete the category from the database
        $subcategory->delete();
    
        // Redirect or return a response
        return redirect()->route('admin.subcategory')->with('success', 'SubCategory deleted successfully!');
    }
}

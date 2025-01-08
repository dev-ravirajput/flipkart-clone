<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Subcategory;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::where('status', 1)->get();
        return view('admin.brands.add', compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:subcategories,id',
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Added max size validation
            'description' => 'required|string',
        ]);

        $slug = \Str::slug($request->name);
        $slugCount = Brand::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }
    
        // Create a new Brand instance
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $slug;
        $brand->status = $request->status;
        $brand->subcategory_id = $request->category_id;
        $brand->description = $request->description;
    
        // Handle the logo file upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('brands', 'public'); // Save the file in the 'brands' directory under 'public' disk
            $brand->logo = $logoPath;
        }
    
        // Save the brand to the database
        $brand->save();
    
        // Redirect with a success message
        return redirect()->route('admin.brands')->with('success', 'Brand Added Successfully');
    }    

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($brand)
    {
        $brand = Brand::find($brand);
        $subcategories = Subcategory::where('status', 1)->get();
        return view('admin.brands.edit', compact('brand', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $brandId)
    {
        // Validate the incoming request data
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Ensure category exists in the categories table
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1', // Status must be either 0 or 1
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Logo must be an image
        ]);

        $slug = \Str::slug($request->name);
        $slugCount = Brand::where('slug', $slug) ->where('id', '!=', $brandId)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }
    
        // Find the brand to update
        $brand = Brand::findOrFail($brandId);
    
        // Update the brand's basic details
        $brand->subcategory_id = $request->input('category_id');
        $brand->slug = $slug;
        $brand->name = $request->input('name');
        $brand->status = $request->input('status');
        $brand->description = $request->input('description');
    
        // Check if a logo image is uploaded
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($brand->logo && Storage::exists($brand->logo)) {
                Storage::delete($brand->logo);
            }
    
            // Store the new logo and update the brand's logo path
            $logoPath = $request->file('logo')->store('brands', 'public');
            $brand->logo = $logoPath;
        }
    
        // Save the updated brand details
        $brand->save();
    
        // Redirect back to the brand edit page or to another page with a success message
        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully.');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($brandId)
{
    // Find the brand by its ID
    $brand = Brand::findOrFail($brandId);

    // Check if the brand has a logo and delete the logo file from storage if it exists
    if ($brand->logo && Storage::exists($brand->logo)) {
        Storage::delete($brand->logo);
    }

    // Delete the brand from the database
    $brand->delete();

    // Redirect back to the brand index page or another page with a success message
    return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully.');
}
}

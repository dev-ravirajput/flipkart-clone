<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Subcategory;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.brands.index');
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
            'subcategory_id' => 'required|exists:subcategories,id',
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Added max size validation
            'description' => 'required|string',
        ]);
    
        // Create a new Brand instance
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->subcategory_id = $request->subcategory_id;
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
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}

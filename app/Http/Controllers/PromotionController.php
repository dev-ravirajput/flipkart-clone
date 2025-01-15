<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.Promotion.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $uploadedImages = [];
    
        // Handle image upload
        foreach ($request->file('images') as $image) {
            $path = $image->store('promotions', 'public'); // Store images in the 'promotions' folder inside 'public' disk
            $uploadedImages[] = $path;
            
            // Save image data in database
            Promotion::create([
                'images' => $path
            ]);
        }
    
        return redirect()->route('admin.promotion'); 
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function deleteImage($image)
{
    $promotionImage = Promotion::where('id', $image)->first();

    if ($promotionImage) {
        Storage::disk('public')->delete($promotionImage->images); // Delete from storage
        $promotionImage->delete(); // Delete from database
    }

    return back()->with('success', 'Image Deleted Successfully!'); // Redirect back with updated images
}

}

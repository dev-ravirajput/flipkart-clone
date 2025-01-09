<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {   
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
    // Validate the incoming data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'profilePic' => 'nullable|image|max:2048', 
    ]);

    $user = auth()->user();

    // Handle the file upload
    if ($request->hasFile('profilePic')) {
        // Delete the old profile picture if it exists
        if ($user->profilePic) {
            \Storage::delete($user->profilePic);
        }

        // Store the new file
        $filePath = $request->file('profilePic')->store('profile_pictures', 'public');
        $validatedData['profilePic'] = $filePath;
    }

    // Update the user with validated data
    $user->update($validatedData);

    // Redirect with a success message
    return redirect()->back()->with('success', 'Profile updated successfully!');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    // Method to show the header (with camera icon)
    public function showHeader()
    {
   // Get the logged-in user's profile image from the database
   $user = Auth::user();
    
   // Fetch the latest profile image for the active user
   $profileImage = DB::table('user_status_imgs')
       ->where('user_id', $user->id)
       ->where('user_status', 'ACTIVE') // Only get ACTIVE status images
       ->orderByDesc('created_at') // Order by latest uploaded
       ->first();

   // Check if the profile image exists, otherwise set to null or default image
   if ($profileImage) {
       // Construct the correct path to the profile image
       $profileImageUrl = asset('storage/' . $profileImage->imagelink);
   } else {
       // Fallback to a default image
       $profileImageUrl = asset('images/default-profile.png');
   }

   // Pass the profile image URL to the view
   return view('user_view.header', compact('profileImageUrl'));
}

    // Method to handle the profile photo upload using DB queries
    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image type and size
        ]);

        // Get the current logged-in user
        $user = Auth::user();

        // Handle the uploaded file
        if ($request->hasFile('profile_image')) {
            // Store the image in public storage
            $image = $request->file('profile_image');
            $imagePath = $image->storeAs('profile_images', time() . '.' . $image->getClientOriginalExtension(), 'public');

            // Use DB to insert into the user_status_imgs table
            DB::table('user_status_imgs')->insert([
                'user_id' => $user->id,
                'user_status' => 'ACTIVE',  // You can modify this value as needed
                'profileName' => $image->getClientOriginalName(),
                'imagelink' => $imagePath, // path to the image in storage
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Optionally, you can return to the page with a success message
            return redirect()->back()->with('success', 'Profile photo uploaded successfully.');
        }

        // If no image was uploaded, return an error message
        return redirect()->back()->with('error', 'Please select a valid image.');
    }
}

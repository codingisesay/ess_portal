<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\userHomePageStatus;

class headerController extends Controller
{
    // Method to show the header (with camera icon)
    public function showHeader()
    {
        $user = Auth::user();
        $userData = DB::table('user_status_imgs')->where('user_id',$user->id)->first();

 // Assign the $permission_array to a session variable
 session(['profile_image' => $userData->imagelink]);

 // dd($permission_array);

 // $permission_array = session('user_edit_id');
 
   return view('user_view.header', compact('userData'));
}

 
    public function uploadProfilePhoto(Request $request)
    {
       $data = $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image type and size
        ]);

        $user = Auth::user();
        $userData = DB::table('user_status_imgs')->where('user_id',$user->id)->first();

        $path = $request->file('profile_image')->store('user_profile_image', 'public');
        $originalFileName = $request->file('profile_image')->getClientOriginalName();

        if ($userData !== null) {
            // Update the record
           $status = DB::table('user_status_imgs')
                ->where('user_id', $user->id)
                ->update([
                    'profileName' => $originalFileName,
                    'imagelink' => $path,
                ]);

                if($status){

                    $this->showHeader();
        
                    return redirect()->route('user.homepage')->with('success','Your Profile image uploaded successfully');
        
                }else{
        
                    return redirect()->route('user.homepage')->with('error','Your Profile image is not uploaded successfully');
        
                }
        } else {
            // Insert a new record if not found
           $status = DB::table('user_status_imgs')->insert([
                'user_id' => $user->id,
                'user_status' => null,
                'profileName' => $originalFileName,
                'imagelink' => $path,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        
            if($status){

                $this->showHeader();
    
                return redirect()->route('user.homepage')->with('success','Your Profile image uploaded successfully');
    
            }else{
    
                return redirect()->route('user.homepage')->with('error','Your Profile image is not uploaded successfully');
    
            }

      

}
}

    public function getUserDetails()
    {
        $user = Auth::user();
        $userDetails = DB::table('users')
            ->select('employeeID', 'name')
            ->where('id', $user->id)
            ->first();

        return $userDetails;
    }
}

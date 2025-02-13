<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

// use App\Events\UserCreated;
class userController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'organisation_id' => 'required',
            'username' => 'required',
            'empid' => 'required',
            'usermailid' => 'required',
            'userpassword' => 'required'

        ]);
    

        $data = $request->all();

        $user_create = User::create([

                      'organisation_id' => $data['organisation_id'],
                      'employeeID' => $data['empid'],
                      'name' => $data['username'],
                      'email' => $data['usermailid'],
                      'password' => bcrypt($data['userpassword'])

                      ]);
                
        if($user_create){

            // Send the registration email
           Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
           return redirect()->route('create_user')->with('success', 'User created successfully!');

        }else{

            return redirect()->route('create_user')->with('error', 'There was an issue creating the user. Please try again.');

        }
    }

    public function index()
    {
        // Fetch all users from the database
        $id = Auth::guard('superadmin')->user()->id;
       
        $users = User::where('organisation_id', $id)->get();
       // dd($users);
        // Pass the data to the view
        return view('superadmin_view.create_user', compact('users'));
    }

}

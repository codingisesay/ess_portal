<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

// use App\Events\UserCreated;
class userController extends Controller
{


    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function register(Request $request){
        $validated = $request->validate([
            'organisation_id' => 'required',
            'username' => 'required',
            'empid' => 'required',
            'usermailid' => 'required',
            'userpassword' => 'required'

        ]);
    

        $data = $request->all();

         $checkExist = User::where('email', $data['usermailid'])->get();

        

        if($checkExist->count() == 0){

            $user_create = User::create([

                'organisation_id' => $data['organisation_id'],
                'employeeID' => $data['empid'],
                'name' => $data['username'],
                'email' => $data['usermailid'],
                'password' => bcrypt($data['userpassword'])

                ]);
          
          if($user_create){

      $subject = 'Welcome to EmployeeXpert';
      $org_id = $data['organisation_id'];
      $mail_flag = "registration_mail";
      $data = [
          'username' => $user_create->email,
          'password' => $request->userpassword,
          'name' => $data['username'],
      ];

      // Send the registration email
  //    Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
     $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);
     return redirect()->route('create_user')->with('success', 'User created successfully!');

  }else{

    return redirect()->route('create_user')->with('error', 'There was an issue creating the user. Please try again.');

  }

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

    public function update(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'empid' => 'required',
            'usermailid' => 'required|email',
        ]);

        $user = User::find($request->user_id);
        $user->name = $request->username;
        $user->employeeID = $request->empid;
        $user->email = $request->usermailid;
       $s = $user->save();

       if($s){
        return redirect()->back()->with('success', 'User updated successfully');
       }else{
        return redirect()->back()->with('error', 'User not updated successfully');
       }
       
    }

}

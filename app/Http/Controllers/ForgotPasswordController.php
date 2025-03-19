<?php 
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\EmailService;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    // Show the password reset request form
    public function showLinkRequestForm()
    {
        return view('forgot_password.auth_passwords_email');
    }

    // Handle the password reset request and send the email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->get();
        // echo $user[0]->email;
        // dd($user);
        // echo $user->count();
        // exit();

        $user[0]->email;

        if($user->count() == 1){

            $checkforduplicate = DB::table('password_reset_tokens')->where('email',$user[0]->email)->get();

            if($checkforduplicate->count() == 1){

                return redirect()->route('password.request')->with('error', 'You Have Alreay Sent a link!');

            }else{

                
        // Create a unique reset token
        $token = Str::random(60);

        // dd($token);

        // Insert the reset token into the password_resets table
        DB::table('password_reset_tokens')->insert([
            'email' => $user[0]->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        
          $resetUrl = route('password.reset', ['token' => $token, 'email' => $user[0]->email]);
        //   exit();
          $subject = 'Password Reset Request';
          $org_id = $user[0]->organisation_id;
          $mail_flag = "forgot_password_link";
          $data = [
              'username' => $user[0]->email,
              'reset_password_link' => $resetUrl,
              'org_id' => $org_id,
          ];

         // Send the reset email
         $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);
        //  return redirect()->route('create_user')->with('success', 'User created successfully!');

        // return back()->with('status', 'We have emailed your password reset link!');
        return redirect()->route('password.request')->with('success', 'Password Reset Link Sent!');

            }


        }else{

            return redirect()->route('password.request')->with('error', 'You Have Not Registered Yet!');

        }

    }

    // Show the password reset form
    public function showResetForm(Request $request, $token)
    {
        return view('forgot_password.auth_passwords_reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Handle the password reset
    public function reset(Request $request)
    {
        // Validate the password reset form
        $request->validate([
            'email' => 'required|email|',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Check if the token is valid
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email']);
        }

        // Update the password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the password reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('user.login')->with('success', 'Your password has been reset!');
    }
}

?>

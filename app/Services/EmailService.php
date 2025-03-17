<?php
namespace App\Services;

use App\Models\organisation;
use App\Models\organisation_config_mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
// use App\Mail\YourMailable;
use App\Mail\UserRegistrationMail;
use App\Mail\UserForgotPassword;
use App\Mail\UserAppliedLeave;
use App\Mail\UserAppliedLeaveStatus;

use Illuminate\Support\Facades\Auth;

class EmailService
{
    /**
     * Send email with dynamic configuration based on the organization.
     *
     * @param int $organizationId
     * @param string $to
     * @param string $subject
     * @param array $data
     * @return void
     */
    
    public function sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data = [])
    {
        // Fetch the organization's mail configuration manually
        // $organization = Organization::find($organizationId);
        // $id = Auth::guard('superadmin')->user()->id;
        
        $id = organisation::where('id', $org_id)->get();
        // dd($id);
        
        if ($id) {
            // Get the mail configuration for this organization
            $mailConfig = DB::table('organisation_config_mails')
                ->where('organisation_id', $id[0]->id)
                ->get();

                // dd($mailConfig);

            if ($mailConfig) {
                // Configure the mail settings dynamically based on the mail configuration
                Config::set('mail.mailers.smtp.host', $mailConfig[0]->MAIL_HOST);
                Config::set('mail.mailers.smtp.port', $mailConfig[0]->MAIL_PORT);
                Config::set('mail.mailers.smtp.username', $mailConfig[0]->MAIL_USERNAME);
                Config::set('mail.mailers.smtp.password', $mailConfig[0]->MAIL_PASSWORD);
                Config::set('mail.mailers.smtp.encryption', $mailConfig[0]->MAIL_ENCRYPTION);
                Config::set('mail.from.address', $mailConfig[0]->MAIL_FROM_ADDRESS);
                Config::set('mail.from.name', $mailConfig[0]->MAIL_FROM_NAME);

                // Send the email
                if($mail_flag == "registration_mail"){

                    Mail::to($data['username'])
                    ->queue(new UserRegistrationMail($subject, $data));  // Pass the subject and data to your mailable

                }elseif($mail_flag == "forgot_password_link"){

                    Mail::to($data['username'])
                    ->queue(new UserForgotPassword($subject, $data));  // Pass the subject and data to your mailable

                }elseif($mail_flag == "applied_leave")
                {

                    Mail::to($data['username'])
                    ->queue(new UserAppliedLeave($subject, $data));  // Pass the subject and data to your mailable

                }elseif($mail_flag == "leave_approve_status"){

                    Mail::to($data['username'])
                    ->queue(new UserAppliedLeaveStatus($subject, $data));  // Pass the subject and data to your mailable

    //                 Mail::to($data['username'])
    // ->cc(['cc1@example.com', 'cc2@example.com']) // Multiple CC recipients
    // ->bcc(['bcc1@example.com', 'bcc2@example.com']) // Multiple BCC recipients
    // ->queue(new UserAppliedLeave($subject, $data));

                }
                else{

                    return response()->json(['error' => 'Mail Not Sent.'], 404); 

                }
                
            } else {
                // Handle case where mail configuration is not found
                return response()->json(['error' => 'Mail configuration not found for this organization.'], 404);
            }
        } else {
            // Handle case where organization is not found
            return response()->json(['error' => 'Organization not found.'], 404);
        }
    }
}
?>
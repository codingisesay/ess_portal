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
   

    public function sendEmailWithOrgConfig($org_id, $subject, $mail_flag, $data = [])
{
    // Fetch the organization and mail configuration
    $org = organisation::find($org_id);
    
    if ($org) {
        // Send the email based on the flag
        switch ($mail_flag) {
            case 'registration_mail':
                Mail::to($data['username'])->queue(new UserRegistrationMail($subject, $data));
                break;

            case 'forgot_password_link':
                Mail::to($data['username'])->queue(new UserForgotPassword($subject, $data));
                break;

            case 'applied_leave':
                Mail::to($data['username'])->cc($data['cc'])->queue(new UserAppliedLeave($subject, $data));
                break;

            case 'leave_approve_status':
                Mail::to($data['username'])->cc($data['cc'])->queue(new UserAppliedLeaveStatus($subject, $data));
                break;

            default:
                return response()->json(['error' => 'Mail flag not recognized.'], 404);
        }
    } else {
        return response()->json(['error' => 'Organization not found.'], 404);
    }
}
}
?>
<?php
namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
// use App\Mail\YourMailable;
use App\Mail\UserRegistrationMail;
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
    public function sendEmailWithOrgConfig($subject, $data = [])
    {
        // Fetch the organization's mail configuration manually
        // $organization = Organization::find($organizationId);
        $id = Auth::guard('superadmin')->user()->id;
        
        if ($id) {
            // Get the mail configuration for this organization
            $mailConfig = DB::table('organisation_config_mail')
                ->where('organisation_id', $id)
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
                Mail::to($data['username'])
                    ->send(new UserRegistrationMail($subject, $data));  // Pass the subject and data to your mailable
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
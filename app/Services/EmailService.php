<?php
namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\YourMailable;

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
    public function sendEmailWithOrgConfig($organizationId, $to, $subject, $data = [])
    {
        // Fetch the organization's mail configuration manually
        $organization = Organization::find($organizationId);
        
        if ($organization) {
            // Get the mail configuration for this organization
            $mailConfig = DB::table('mail_configurations')
                ->where('id', $organization->mail_configuration_id)
                ->first();

            if ($mailConfig) {
                // Configure the mail settings dynamically based on the mail configuration
                Config::set('mail.mailers.smtp.host', $mailConfig->mail_host);
                Config::set('mail.mailers.smtp.port', $mailConfig->mail_port);
                Config::set('mail.mailers.smtp.username', $mailConfig->mail_username);
                Config::set('mail.mailers.smtp.password', $mailConfig->mail_password);
                Config::set('mail.mailers.smtp.encryption', $mailConfig->mail_encryption);
                Config::set('mail.from.address', $mailConfig->mail_from_address);
                Config::set('mail.from.name', $mailConfig->mail_from_name);

                // Send the email
                Mail::to($to)
                    ->send(new YourMailable($subject, $data));  // Pass the subject and data to your mailable
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
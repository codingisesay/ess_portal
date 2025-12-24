<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
// Import the Mailable class
use App\Mail\SendOrganisationCredentialsMail;
use App\Jobs\SendSubscriptionExpiryMail;
use Illuminate\Support\Facades\Log;
 
class AdminDashboardController extends Controller
{
    // Show admin dashboard
    public function adminDashboard(): View
    {
         // Get the expiry alerts
        $expiryAlerts = $this->getExpiryAlerts();

        // Get the subscription plans
        $subscriptionPlans = $this->getSubscriptionPlans();

        // Get the organisations
        $organisations = $this->getOrganisations();

        // Get the expiry count
         $today = now()->toDateString();
        $alertDate = now()->addDays(7)->toDateString();
        // Count organisations with expiry dates within the next 7 days
        $expiryCount = \DB::table('organisations')
            ->whereBetween('expire_date', [$today, $alertDate])
            ->count();

        // Return the dashboard view and pass the data
        return view('admin_view.dashboard', compact('expiryAlerts', 'subscriptionPlans', 'organisations', 'expiryCount'));
    }


    //created a function to show all client details
     public function clientAllDetails(){
        // Fetch all organisations data
        $organisations = $this->getOrganisations();

        // Pass the organisations data to the client details view 
        // handle casesensative file systems
        return view('admin_view.Client_all_details', compact('organisations'));
    }


// Method to insert new organisation details with welcome email
  public function clientmasterinsert(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'client_name' => 'nullable',
        'email' => 'required|email',
        'password' => 'required',

        'contact_person' => 'nullable',
        'mobile' => 'nullable',

        // Address
        'building_no' => 'nullable',
        'premises_name' => 'nullable',
        'landmark' => 'nullable',
        'road_street' => 'nullable',
        'pincode' => 'nullable',
        'district' => 'nullable',
        'state' => 'nullable',
        'country' => 'nullable',

        'GST_number' => 'nullable',
        'industry_type' => 'nullable',
        'number_of_emplooyees' => 'nullable',
        'software_package_plan' => 'nullable',
        'storage_limit' => 'nullable',
        'number_of_user_allowed' => 'nullable',
        'TAN' => 'nullable',
        'PAN' => 'nullable',
        'expire_date' => 'nullable',

        // Certificates
        'MSME_udyam_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'GST_registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

        'organisation_status' => 'nullable|in:Active,Incative',
    ]);

    // 🔹 Store plain password for email
    $plainPassword = $data['password'];

    // 🔹 Hash password for DB
    $data['password'] = bcrypt($data['password']);

    // Handle file uploads
    if ($request->hasFile('MSME_udyam_certificate')) {
        $data['MSME_udyam_certificate'] = file_get_contents(
            $request->file('MSME_udyam_certificate')
        );
    }

    if ($request->hasFile('GST_registration_certificate')) {
        $data['GST_registration_certificate'] = file_get_contents(
            $request->file('GST_registration_certificate')
        );
    }

    // 🔹 Insert organisation
    DB::table('organisations')->insert($data);
    // 🔹 Send welcome email 
    SendOrganisationCredentialsMail::dispatch(
        $data['email'],
        $plainPassword,
        url('/superadmin/login')
    );

    return back()->with('success', 'Organisation created. Credentials email queued!');
}



// Method to update organisation details
public function clientmasterupdate(Request $request, $id)
{
    $organisation = \DB::table('organisations')->where('id', $id)->first();

    if (!$organisation) {
        return back()->with('error', 'Organisation not found');
    }

    $data = $request->validate([
        'name' => 'required',
        'client_name' => 'nullable',
        'email' => 'required|email|max:50|unique:organisations,email,' . $id,

        // Password optional on update
        'password' => 'nullable',

        'contact_person' => 'nullable',
        'mobile' => 'nullable|string|max:15',

        // Status from Edit Client popup:
        // - Checkbox sends '1' when Active is toggled on
        // - Hidden input ensures a '0' is sent when toggled off
        // Accept only 0 or 1 to persist boolean status safely
        'status' => 'nullable|in:0,1',

        // Address
        'building_no' => 'nullable',
        'premises_name' => 'nullable',
        'landmark' => 'nullable',
        'road_street' => 'nullable',
        'pincode' => 'nullable',
        'district' => 'nullable',
        'state' => 'nullable',
        'country' => 'nullable',

        'GST_number' => 'nullable',
        'industry_type' => 'nullable',
        'number_of_emplooyees' => 'nullable',
        'software_package_plan' => 'nullable',
        'storage_limit' => 'nullable',
        'number_of_user_allowed' => 'nullable',
        'TAN' => 'nullable',
        'PAN' => 'nullable',
        'expire_date' => 'nullable|date',

        // Certificates
        'MSME_udyam_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'GST_registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

        'organisation_status' => 'nullable|in:Active,Incative',
    ]);

    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']); // don't update password
    }

    // File uploads
    if ($request->hasFile('MSME_udyam_certificate')) {
        $data['MSME_udyam_certificate'] = file_get_contents($request->file('MSME_udyam_certificate'));
    }

    if ($request->hasFile('GST_registration_certificate')) {
        $data['GST_registration_certificate'] = file_get_contents($request->file('GST_registration_certificate'));
    }

    // Update organisation
    \DB::table('organisations')->where('id', $id)->update($data);

    // If organisation_status present, update all users of that organisation
    if (array_key_exists('organisation_status', $data)) {
        $orgStatus = (string) $data['organisation_status'];
        $normalized = strtolower(trim($orgStatus));

        if ($normalized === 'active') {
            \DB::table('users')
                ->where('organisation_id', $id)
                ->update(['user_status' => 'Active']);
        } else {
            // Any value other than 'active' (including 'Incative') will be treated as inactive
            \DB::table('users')
                ->where('organisation_id', $id)
                ->update(['user_status' => 'Inactive']);
        }
    }

    return back()->with('success', 'Organisation updated successfully!');
}

// Method to get list of organisations users
    public function getOrganisations()
    {
        $organisations = \DB::table('organisations')->orderBy('id', 'ASC')->get();
        return $organisations;
    }

    /**
     * Display the specified certificate file.
     *
     * @param  int  $id
     * @param  string  $type  Type of certificate (msme or gst)
     * @return \Illuminate\Http\Response
     */
    public function viewCertificate($id, $type)
    {
        $organisation = DB::table('organisations')->find($id);
        
         // Determine certificate field and base filename based on type
        $certificateField = $type === 'msme' ? 'MSME_udyam_certificate' : 'GST_registration_certificate';
        $certificateName = $type === 'msme' ? 'msme_certificate' : 'gst_certificate';
        
        // Retrieve binary file content from database
        $fileContent = $organisation->$certificateField;
        
        // Determine content type which is stored in binary format of databse
        $finfo = new \finfo(FILEINFO_MIME);
        $mimeType = $finfo->buffer($fileContent);
        
        // Adjust extension based on type
        $extension = 'pdf'; // default
        if (str_contains($mimeType, 'image/png')) {
            $extension = 'png';
        } elseif (str_contains($mimeType, 'image/jpeg')) {
            $extension = 'jpg';
        }
        
         // Build filename for browser display
        $filename = "{$certificateName}_{$organisation->id}.{$extension}";
        
         // Return file response with inline display
        return response($fileContent)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', "inline; filename=\"{$filename}\"")
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


// Method to insert new subscription plan
public function saveSubscriptionPlan(Request $request)
{
    $data = $request->validate([
        'plan_name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'price_monthly' => 'nullable|numeric',
        'price_yearly' => 'nullable|numeric',
        'max_users' => 'nullable|integer',
        'max_storage_gb' => 'nullable|integer',
        'max_employees' => 'nullable|integer',
        'max_branches' => 'nullable|integer',
        'trial_days' => 'nullable|integer',
        'is_popular' => 'nullable|boolean',
        'status' => 'required|string',
    ]);

    \DB::table('subscription_plans')->insert([
        'plan_name' => $data['plan_name'],
        'description' => $data['description'] ?? null,
        'price_monthly' => $data['price_monthly'] ?? null,
        'price_yearly' => $data['price_yearly'] ?? null,
        'max_users' => $data['max_users'] ?? null,
        'max_storage_gb' => $data['max_storage_gb'] ?? null,
        'max_employees' => $data['max_employees'] ?? null,
        'max_branches' => $data['max_branches'] ?? null,
        'trial_days' => $data['trial_days'] ?? 0,
        'is_popular' => $data['is_popular'] ?? 0,
        'status' => $data['status'],
        'created_at' => now(),
    ]);

    return back()->with('success', 'Subscription plan created successfully');
}

// Method to update existing subscription plan
public function updateSubscriptionPlan(Request $request, $id)
{
    $data = $request->validate([
        'plan_name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'price_monthly' => 'nullable|numeric',
        'price_yearly' => 'nullable|numeric',
        'max_users' => 'nullable|integer',
        'max_storage_gb' => 'nullable|integer',
        'max_employees' => 'nullable|integer',
        'max_branches' => 'nullable|integer',
        'trial_days' => 'nullable|integer',
        'is_popular' => 'nullable|boolean',
        'status' => 'required|string',
    ]);

    \DB::table('subscription_plans')
        ->where('id', $id)
        ->update([
            'plan_name' => $data['plan_name'],
            'description' => $data['description'] ?? null,
            'price_monthly' => $data['price_monthly'] ?? null,
            'price_yearly' => $data['price_yearly'] ?? null,
            'max_users' => $data['max_users'] ?? null,
            'max_storage_gb' => $data['max_storage_gb'] ?? null,
            'max_employees' => $data['max_employees'] ?? null,
            'max_branches' => $data['max_branches'] ?? null,
            'trial_days' => $data['trial_days'] ?? 0,
            'is_popular' => $data['is_popular'] ?? 0,
            'status' => $data['status'],
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Subscription plan updated successfully');
}
// Method to get list of subscription plans
public function getSubscriptionPlans()
{
    $plans = \DB::table('subscription_plans')
        ->orderBy('id', 'ASC')
        ->get();
    return $plans;
}
// Method to get organisations with expiry alerts within next 7 days with plan details
public function getExpiryAlerts()
{
    $today = now()->toDateString();
    $alertDate = now()->addDays(7)->toDateString();

    $organisationsexpiry = \DB::table('organisations')
        ->join('subscription_plans', 'subscription_plans.id', '=', 'organisations.software_package_plan')
        ->select(
            'organisations.id',
            'organisations.name',
            'organisations.expire_date',
            'subscription_plans.plan_name'
        )
        ->whereBetween('organisations.expire_date', [$today, $alertDate])
        ->orderBy('organisations.expire_date', 'ASC')
        ->get();

    return response()->json($organisationsexpiry);
}


// Method to send expiry alert emails to organisations
public function sendExpiryEmails()
{
    $today = now()->toDateString();
    $alertDate = now()->addDays(7)->toDateString();

    $organisations = DB::table('organisations')
        ->whereBetween('expire_date', [$today, $alertDate])
        ->get();

    foreach ($organisations as $org) {
        SendSubscriptionExpiryMail::dispatch(
            $org->email,
            $org->name,
            $org->expire_date
        );
    }

    return response()->json([
        'status' => true,
        'message' => 'Expiry emails queued successfully'
    ]);
}


}
 
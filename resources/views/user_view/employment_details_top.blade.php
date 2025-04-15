<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}">
    {{-- <title>Employee Details</title> --}}
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<div class="employee-info">
<div class="profile-image1 text-center">
            <?php 
            $profileimahe = session('profile_image');
            ?>
            <img id="profile-image" src="{{ asset('storage/'.$profileimahe) }}" class="profile-image" alt="Profile Picture"> <br><br>
            <h2 id="emp-name">{{ ucfirst($userDetails->name ?? '-') }}</h2>
        </div>
        <table class="job-title">
            <tr><td>Designation</td> <td id="emp-designation">{{ ucfirst($userDetails->designation_name ?? '-') }}</td></tr>
            <tr><td>Department</td> <td id="emp-department">{{ ucfirst($userDetails->department_name ?? '-') }}</td></tr>
            <tr><td>Office</td> <td id="emp-city">{{ ucfirst($userDetails->branch_name ?? '-') }}</td></tr>
            <tr><td>Reporting Manager</td> <td id="emp-manager">{{ ucfirst($userDetails->reporting_manager_name ?? '-') }}</td></tr>
        </table>
        </div> 
         
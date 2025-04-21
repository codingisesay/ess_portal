<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}">
    <!-- {{-- <title>Employee Details</title> --}} -->
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
    <div class="employee-info">
        <div class="profile-image1 text-center">
            <?php 
            $profileimahe = session('profile_image');
            ?>
            <img id="profile-image" src="{{ asset('storage/'.$profileimahe) }}" class="profile-image mb-2" alt="Profile Picture"> 
            <h4 id="emp-name">{{ ucfirst($userDetails->name ?? '-') }}</h4>
        </div>
        <hr>
        <div class="key-val-flex-block">
            <p><strong>Designation</strong> <weak id="emp-designation">{{ ucfirst($userDetails->designation_name ?? '-') }}</weak></p>
            <p><strong>Department</strong> <weak  id="emp-department">{{ ucfirst($userDetails->department_name ?? '-') }}</weak></p>
            <p><strong>Office</strong> <weak id="emp-city">{{ ucfirst($userDetails->branch_name ?? '-') }}</weak></p>
            <p><strong>Reporting Manager</strong> <weak  id="emp-manager">{{ ucfirst($userDetails->reporting_manager_name ?? '-') }}</weak></p>
        </div>
    </div> 
         
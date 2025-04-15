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
        <img id="profile-image" src="{{ asset('storage/'.$profileimahe) }}" class="profile-image" alt="Profile Picture"> 
            <br><br>
        <h2 id="emp-name " class="fs-4">{{ ucfirst($userDetails->name ?? '-') }}</h2>
    </div>
    <hr>
    <table>
        <tr>
            <td><strong>Designation</strong></td>
            <td><weak id="emp-designation">{{ ucfirst($userDetails->designation_name ?? '-') }}</weak></td>
        </tr>
        <tr>
            <td><strong>Department</strong></td>
            <td><weak id="emp-department">{{ ucfirst($userDetails->department_name ?? '-') }}</weak></td>
        </tr>
        <tr>
            <td><strong>Office</strong></td>
            <td><weak id="emp-city">{{ ucfirst($userDetails->branch_name ?? '-') }}</weak></td>
        </tr>
        <tr>
            <td><strong>Reporting Manager</strong></td>
            <td><weak id="emp-manager">{{ ucfirst($userDetails->reporting_manager_name ?? '-') }}</weak></td>
        </tr>
    </table>

</div> 
        
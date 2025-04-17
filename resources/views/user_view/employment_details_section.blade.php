<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}">
    <!-- {{-- <title>Employee Details</title> --}} -->
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<!-- <div class="employment-details"> -->
    <!-- <h1>Employment Details</h1> -->
    <div class="employee-info">
        
        <div class="contact-details">
            <h5>Contact Details</h5> 
            <p><strong>Phone Number</strong> <weak id="emp-phone">{{ ucfirst($userDetails->offical_phone_number ?? '-') }}</weak></p>
            <p><strong>Alternate Number</strong> <weak id="emp-alternate-phone">{{ ucfirst($userDetails->alternate_phone_number ?? '-') }}</weak></p>
            <p><strong>Email Address</strong> <weak><a href="mailto:{{ $userDetails->email ?? '-' }}" id="emp-email">{{ ucfirst($userDetails->email ?? '-') }}</a></weak></p>
         
                <hr>
            <h5>Address</h5>
            <p><strong>Permanent</strong> <weak id="emp-permanent-address">
            {{ ucfirst(trim($userDetails->per_building_no) ? $userDetails->per_building_no . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_name_of_premises) ? $userDetails->per_name_of_premises . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_nearby_landmark) ? $userDetails->per_nearby_landmark . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_road_street) ? $userDetails->per_road_street . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_city) ? $userDetails->per_city . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_district) ? $userDetails->per_district . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_state) ? $userDetails->per_state . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_country) ? $userDetails->per_country . ',' : '') }}
            {{ ucfirst(trim($userDetails->per_pincode) ? $userDetails->per_pincode : '') }}

            </weak></p>
            <p><strong>Correspondance</strong> <weak id="emp-correspondance-address">
            {{ ucfirst($userDetails->cor_building_no ? $userDetails->cor_building_no . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_name_of_premises) ? $userDetails->cor_name_of_premises . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_nearby_landmark) ? $userDetails->cor_nearby_landmark . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_road_street) ? $userDetails->cor_road_street . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_city) ? $userDetails->cor_city . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_district) ? $userDetails->cor_district . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_state) ? $userDetails->cor_state . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_country) ? $userDetails->cor_country . ',' : '') }}
            {{ ucfirst(trim($userDetails->cor_pincode) ? $userDetails->cor_pincode : '') }}

            </weak></p>
            <hr>
             
            <p><strong>Kin Name</strong> <weak id="emp-contactperson">{{ ucfirst($userDetails->emergency_contact_person ?? '-') }}</weak></p>
            <p><strong>Kin Contact No.</strong> <weak id="emp-contactnumber">{{ ucfirst($userDetails->emergency_contact_number ?? '-') }}</weak></p>     
                
        </div>
    </div>
   
<!-- </div> -->

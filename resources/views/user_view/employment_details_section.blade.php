<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}">
    {{-- <title>Employee Details</title> --}}
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<!-- <div class="employment-details"> -->
    <!-- <h1>Employment Details</h1> -->
    <div class="employee-info">
        
        <div class="contact-details">
            <h3>Contact Details</h3>
            <p><strong>Phone Number</strong> <weak id="emp-phone">{{ ucfirst($userDetails->offical_phone_number ?? '-') }}</weak></p>
            <p><strong>Alternate Number</strong> <weak id="emp-alternate-phone">{{ ucfirst($userDetails->alternate_phone_number ?? '-') }}</weak></p>
            <p><strong>Email Address</strong> <weak><a href="mailto:{{ $userDetails->email ?? '-' }}" id="emp-email">{{ ucfirst($userDetails->email ?? '-') }}</a></weak></p>
            <h3>Address</h3>
            <p><strong>Permanent</strong> <weak id="emp-permanent-address">
                {{ ucfirst($userDetails->per_building_no ?? '') }},
                {{ ucfirst($userDetails->per_name_of_premises ?? '') }},
                {{ ucfirst($userDetails->per_nearby_landmark ?? '') }},
                {{ ucfirst($userDetails->per_road_street ?? '') }},
                {{ ucfirst($userDetails->per_city ?? '') }},
                {{ ucfirst($userDetails->per_district ?? '') }},
                {{ ucfirst($userDetails->per_state ?? '') }},
                {{ ucfirst($userDetails->per_country ?? '') }},
                {{ ucfirst($userDetails->per_pincode ?? '') }}
            </weak></p>
            <p><strong>Correspondance</strong> <weak id="emp-correspondance-address">
                {{ ucfirst($userDetails->cor_building_no ?? '') }},
                {{ ucfirst($userDetails->cor_name_of_premises ?? '') }},
                {{ ucfirst($userDetails->cor_nearby_landmark ?? '') }},
                {{ ucfirst($userDetails->cor_road_street ?? '') }},
                {{ ucfirst($userDetails->cor_city ?? '') }},
                {{ ucfirst($userDetails->cor_district ?? '') }},
                {{ ucfirst($userDetails->cor_state ?? '') }},
                {{ ucfirst($userDetails->cor_country ?? '') }},
                {{ ucfirst($userDetails->cor_pincode ?? '') }}
            </weak></p>
        </div>
    </div>
    <div class="emergency-contact">
        <h2>Emergency Contact Details</h2>
        <p><strong>Name</strong> <weak id="emp-contactperson">{{ ucfirst($userDetails->emergency_contact_person ?? '-') }}</weak></p>
        <p><strong>Contact Number</strong> <weak id="emp-contactnumber">{{ ucfirst($userDetails->emergency_contact_number ?? '-') }}</weak></p>              
    </div>
<!-- </div> -->

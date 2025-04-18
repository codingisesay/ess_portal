@extends('user_view.header')
@section('content')
<?php
// $user = Auth::user();
// dd($user);
// dd($employees_login);

// exit();
function renderEmployeeNode($employee) {
    $hasSubordinates = !empty($employee->subordinates);
    ob_start();
    ?>
    <li>
        <?php if ($hasSubordinates): ?>
            <!-- Display the toggle button for employees with subordinates -->
            <button class="toggle-button" data-user-id="<?= $employee->user_id ?>" onclick="toggleChildren(this)">
                +
            </button>
        <?php else: ?>
            <!-- Display a dot for employees without subordinates -->
            <span class="dot">•</span>
        <?php endif; ?>

        <span onclick="displayEmployeeDetails(
            '<?= $employee->user_id ?>',
            '<?= $employee->employee_name ?>', 
            '<?= $employee->designation ?>',
            '<?= $employee->reporting_manager_name ?>',
            '<?= $employee->department ?>',
            '<?= $employee->branch_name ?>',
            '<?= $employee->offical_phone_number ?>',
            '<?= $employee->alternate_phone_number ?>',
            '<?= $employee->offical_email_address ?>',
            '<?= $employee->emergency_contact_person ?>',
            '<?= $employee->emergency_contact_number ?>',
            '<?= !empty($employee->profile_image) ? asset('storage/' . $employee->profile_image) : asset('storage/user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg') ?>',
            '<?= $employee->permanent_address ?>',
            '<?= $employee->correspondance_address ?>'
        )">
            <?php 
            // Gender-specific image display
            if ($employee->gender == 'Male') {
                echo '<img src="' . asset('user_end/images/man2.png') . '" alt="Male" style="width:20px; height:20px; margin-right: 5px;">';
            } elseif ($employee->gender == 'Female') {
                echo '<img src="' . asset('user_end/images/woman.png') . '" alt="Female" style="width:20px; height:20px; margin-right: 5px;">';
            } else {
                echo '<img src="' . asset('user_end/images/male-and-female.png') . '" alt="Gender Neutral" style="width:20px; height:20px; margin-right: 5px;">'; // You can use a gender-neutral icon here if needed
            }
            ?>
            <?= $employee->employee_name ?>
        </span>
        <?php if ($hasSubordinates): ?>
            <ul data-manager-id="<?= $employee->user_id ?>" style="display: block;">
                <?php foreach ($employee->subordinates as $subordinate) {
                    echo renderEmployeeNode($subordinate);
                } ?>
            </ul>
        <?php endif; ?>
    </li>
    <?php
    return ob_get_clean();
}
?>
<?php 
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Organisation Chart</title> --}}
    <link rel="icon" href= "../resource/image/common/STPLLogo butterfly.png" />
    <link rel="stylesheet" href="{{ asset('/user_end/css/organisation.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="header">
    <div class="organization-name">
        Organization Hierarchy
    </div>
    <div class="dropdown">
        <select id="display-option" onchange="changeDisplayMode()">
            <option value="horizontal">Horizontal Organization Chart</option>
            <option value="vertical">Vertical Organization Chart</option>
        </select>
    </div>
    <div class="search-bar-container">
        <input type="text" id="search-bar" placeholder="Search Employee Name..." onkeyup="highlightEmployee()">
        <span class="search-icon"> <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon"></span>
    </div>
</div>

<div class="container">  
<div class="employee-list">
        <ul class="tree">
            @foreach ($employeeHierarchy as $employee)
                {!! renderEmployeeNode($employee) !!}
            @endforeach
        </ul>
    </div>
    <div class="employee-details">  
    <div class="left">  
           @include('user_view.employment_details_top')
        </div> 
        <div class="right">
        
     <!-- Include employment details section -->
     @include('user_view.employment_details_section')
</div>

    </div>  
</div>  

<script>  
    // Function to toggle s of employee children  
    // function toggleChildren(button) {
    //     const userId = button.getAttribute('data-user-id');
    //     const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
    //     if (childrenContainer) {
    //         const isVisible = childrenContainer.style.display === "block";
    //         childrenContainer.style.display = isVisible ? "none" : "block";
    //         button.textContent = isVisible ? "+" : "-";
    //     }
    // }
    document.addEventListener('DOMContentLoaded', function() {
    // Find all buttons that control subordinates visibility
    const buttons = document.querySelectorAll('[data-user-id]');
    
    buttons.forEach(button => {
        const userId = button.getAttribute('data-user-id');
        const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
        
        // Check the initial visibility of the ul (subordinates list)
        if (childrenContainer && childrenContainer.style.display === "block") {
            // If it's visible, set the button text to "-"
            button.textContent = "-";
        }
    });
});

function toggleChildren(button) {
    const userId = button.getAttribute('data-user-id');
    const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
    if (childrenContainer) {
        const isVisible = childrenContainer.style.display === "block";
        childrenContainer.style.display = isVisible ? "none" : "block"; // Toggle visibility
        button.textContent = isVisible ? "+" : "-"; // Change button text
    }
}



    function displayEmployeeDetails(userId, name, designation, manager, department, city, phone, alternatephone, email, contactperson, contactnumber, profileImage, permanentAddress, correspondanceAddress) {  
    document.getElementById('emp-name').textContent = name;  
    document.getElementById('emp-designation').textContent = designation;  
    // document.getElementById('emp-no').textContent = empNo;  
    document.getElementById('emp-manager').textContent = manager;  
    document.getElementById('emp-department').textContent = department;  
    document.getElementById('emp-city').textContent = city;  
    document.getElementById('emp-phone').textContent = phone;  
    document.getElementById('emp-alternate-phone').textContent = alternatephone;
    document.getElementById('emp-email').textContent = email;
    document.getElementById('emp-permanent-address').textContent = permanentAddress;
    document.getElementById('emp-correspondance-address').textContent = correspondanceAddress;
    document.getElementById('emp-contactperson').textContent = contactperson;
    document.getElementById('emp-contactnumber').textContent = contactnumber;
    // Update the profile image
    document.getElementById('profile-image').src = profileImage || '{{ asset('storage/' .$profileimahe) }}';
}

    function highlightEmployee() {  
        const searchQuery = document.getElementById('search-bar').value.toLowerCase();  
        const employees = document.querySelectorAll('.tree span');  

        employees.forEach(employee => {  
            // Highlight matching names or remove highlight  
            if (searchQuery && employee.textContent.toLowerCase().includes(searchQuery)) {  
                employee.classList.add('highlight');  
            } else {  
                employee.classList.remove('highlight');  
            }  
        });  
    }  

    // Function to change display mode  
    function changeDisplayMode() {  
        const displayOption = document.getElementById('display-option').value;  

        if (displayOption === 'horizontal') {  
            // Redirect to org.php when horizontal chart is selected  
            window.location.href = "{{ route('user.view.horizontal.organisation') }}"; 
             
        }  
        // Default behavior for vertical chart can be handled without alert  
    }  

    // Set default selected option to "Vertical" and display employee details on load
window.onload = function() {  
    document.getElementById('display-option').value = 'vertical'; // Set default to Vertical chart  

    // Get the employee details from Laravel session
    const empName = "{{ $employees_login->employee_name }}";
    const empDesignation = "{{ $employees_login->designation }}";
    const empNo = "{{ $employees_login->employee_no }}";
    const empManager = "{{ $employees_login->reporting_manager_name }}"; // Ensure this is the manager's name
    const empDepartment = "{{ $employees_login->department }}";
    const empCity = "{{ $employees_login->branch_name }}";  
    const empPhone = "{{ $employees_login->offical_phone_number }}";
    const empAlternatephone = "{{ $employees_login->alternate_phone_number }}";
    const empEmail = "{{ $employees_login->offical_email_address }}";
    const permanentAddress = "{{ $employees_login->permanent_address }}";
    const correspondanceAddress = "{{ $employees_login->correspondance_address }}";
    const empContactperson = "{{ $employees_login->emergency_contact_person }}";
    const empContactnumber = "{{ $employees_login->emergency_contact_number }}";
    // const profileImage = "{{ asset('storage/' .$profileimahe) }}"; // Get the profile image from session
// const profileImage = "{{ !empty($employees_login->profile_image) ? asset('storage/' . $employees_login->profile_image) : asset('storage/user_profile_image/default.jpg') }}";
    const profileImage = "{{ !empty($employees_login->profile_image) ? asset('storage/' . $employees_login->profile_image) : '' }}";
    // Call the function to display the logged-in employee details
    displayEmployeeDetails(empNo, empName, empDesignation, empManager, empDepartment, empCity, empPhone, empAlternatephone, empEmail, empContactperson, empContactnumber, profileImage, permanentAddress, correspondanceAddress);
};
</script>

<style>
    .custom-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0px 0;
    table-layout: auto;
    margin-bottom: 70px;
}

.custom-table th,
.custom-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    white-space: nowrap;
    font-weight: bold;
}

.custom-table th {
    background-color: unset;
    font-weight: normal;
}

.custom-table tr:nth-child(even) {
    background-color: white;
}

.custom-table tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.tree {
    list-style-type: none;
    padding-left: 20px;
    position: relative;
}

.tree li {
    margin: 5px 0;
    padding-left: 20px;
    position: relative;
}

/* Add vertical line */
.tree li::before {
    content: "";
    position: absolute;
    top: -21px;
    left: 0;
    width: 10px;
    height: 100%;
    border-left: 1px solid #ccc;
}

/* Add horizontal line */
.tree li::after {
    content: "";
    position: absolute;
    top: 24px;
    left: 1px;
    width: 12px;
    height: 1px;
    border-top: 1px solid #ccc;
}

/* Remove lines for root element */
.tree > li::before {
    display: none;
}
/* 
.tree li span {
    cursor: pointer;
    padding: 5px 10px;
    background-color: #f5f5f5;
    border-radius: 5px;
    display: inline-block;
    border: 1px solid #ccc;
} */

</style>

<style>
    /* CSS code omitted for brevity. Retain your original CSS here. */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
    }

    header{
        width: 100% !important;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        background-color: #f5f5f5;
        border-radius: 10px;
        width: 100%;
        height: 30px;
    }

    .header .organization-name {
        font-size: 30px;
        font-weight: bold;
        margin-left: 15px;
    }

    .header .search-bar-container {
        display: flex;
        align-items: center;
        background-color: #f5f5f5;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border: solid #FFFFFF 5px;
        height: 50px;
        width: 250px;
        position: relative;
    }

    .header .search-bar-container input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        padding: 0 10px;
        font-size: 14px;
        color: #333;
    }

    .header .search-bar-container .search-icon {
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #8A3366;
        border-radius: 50%;
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: white;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 2px solid white;
    }

    .header .search-bar-container .search-icon img {
        width: 50%;
        height: 50%;
        object-fit: cover;
        border-radius: 50%;
    }

    .container {
        width: 100%;
        /* max-width: 1500px; */
        background-color: #f5f5f5;
        border-radius: 15px;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 4fr;
        gap: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        /* height: 550px; */
        overflow: hidden;
        margin-bottom: 50px;
    }

    .employee-list {
        grid-column: 1;
        padding: 10px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        height: 100%;
        width: 420px;
    }

    .employee-list ul {
        list-style: none;
        padding-left: 0;
    }

    .employee-list li {
        margin: 5px 0;
        padding: 5px;
        cursor: pointer;
        padding-bottom: 0px;
        padding-left: 17px;
        font-size: 14px;
    }

    .employee-details {
        grid-column: 2 / 3;
        display: flex;
        flex-direction: row;
        gap: 20px;
        overflow-y: auto;
        height: 100%;
    }

    .employee-details .left {
        /* width: 30%; */
        width: 50%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: auto;
        font-weight: bold;
    }

    .employee-details .left .heading {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        background-color: #FFC107;
        color: #FFFFFF;
        width: 180px;
        height: 37px;
        border-radius: 7px;
        padding: 2px;
        margin-left: 25px;
    }
     
    .employee-details .right .title {
        font-weight: bold;
        font-size: 30px;
        margin-bottom: 10px;    
    }

    .employee-details .left .profile-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #ddd;
        margin: 0 auto 15px;
        overflow: hidden;
        margin-top: 50px;
    }

    .employee-details .left img {
        /* width: 50%;
        height: 50%; */
        object-fit: cover;
    }

    /* .employee-details .right {
        width: 100%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        height: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 15px;
        overflow-y: auto;
    } */

    .employee-details .right {
    width: 100%;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 15px;
    overflow-y: auto;
}

/* Hide the scrollbar */
.employee-details .right::-webkit-scrollbar {
    display: none;
}


    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 15px;
        font-weight: bold;
    }

    .detail-item span:first-child {
        color: darkgrey;
        flex: 1;
        text-align: left;
        margin-left: 100px;
    }

    .detail-item span:last-child {
        color: black;
        flex: 2;
        text-align: left;
    }

    .notes {
        grid-column: 1 / 3;
        background-color: #FFFFFF;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 935px;
        margin-left: 480px;
        margin-top: -250px;
        height: 180px;
        padding-top: 20px;
    }

    .notes h3 {
        text-align: center;
        border-radius: 7px;
        padding: 5px;
        background-color: #FFC107;
        color: #FFFFFF;
        width: 180px;
        margin: 0px;
        height: 37px;
    }

    .highlight {
        background-color: #E0AFA0;
        font-weight: bold;
        /* color: white; */
    }

    .gender-icon {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        margin-right: 8px;
    }

    .icon-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 10px;
    }

    .icon-container a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 15px;
        height: 15px;
        background-color: #F6F5F7;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        color: white;
        text-decoration: none;
        font-size: 20px;
    }

    .icon-container a img {
        width: 20%;
        height: 20%;
    }

    .dropdown {
        margin-left: 15px;
        position: relative;
    }

    .dropdown select {
        padding: 5px 10px;
        font-size: 14px;
        border: 2px solid white;
        border-radius: 10px;
        background-color: #f5f5f5;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .toggle-button {
        /* background: none; */
        border: none;
        cursor: pointer;
        font-size: 16px;
        margin-right: 5px;
    }
    .tree {
    list-style-type: none;
    padding-left: 20px;
}

.tree li {
    margin: 5px 0;
    padding-left: 10px;
    position: relative;
}



/* .tree li::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 10px;
    height: 100%;
    border-left: 1px solid #ccc;
} */

.tree li span {
    cursor: pointer;
    padding: 5px;
    display: inline-block;
    border-radius: 5px;
    transition: background 0.3s;
}

.tree li span:hover {
    background: #f4f4f4;
}

.toggle-button {
    margin-right: 5px;
    cursor: pointer;
    background: white;
    color: black;
    border: none;
    padding: 2px 6px;
    border-radius: 50%;
    font-weight: bold;
}

</style>

@endsection
@extends('user_view.header')
@section('content')
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
        <input type="text" id="search-bar" placeholder="Search here..." onkeyup="highlightEmployee()">
        <span class="search-icon"><img src="../resource/image/common/search (1).png" alt="Search Icon"></span>
    </div>
</div>

<div class="container">  
    <div class="employee-list">  
        <ul class="tree">  
            @foreach ($employees as $employee)
            @if ($employee->reporting_manager == $noneUserId)  <!-- Check for the top-level managers dynamically -->
                                <li>
                                    @php
                                        $hasSubordinates = false;
                                        foreach ($employees as $subordinate) {
                                            if ($subordinate->reporting_manager == $employee->user_id) {
                                                $hasSubordinates = true;
                                                break;
                                            }
                                        }
                                    @endphp
                        @if ($hasSubordinates)
                            <button class="toggle-button" data-user-id="{{ $employee->user_id }}" onclick="toggleChildren(this)">+</button>
                        @endif
                        <span onclick="displayEmployeeDetails(
                            '{{ $employee->user_id }}',
                            '{{ $employee->employee_name }}',
                            '{{ $employee->designation }}',
                            '{{ $employee->employee_no }}',
                            '{{ $employee->reporting_manager_name }}',
                            '{{ $employee->department }}',
                            '{{ $employee->per_city }}',
                            '{{ $employee->offical_phone_number }}',
                            '{{ $employee->offical_email_address }}'
                        )">
                            {{ $employee->employee_name }}
                        </span>
                        @if ($hasSubordinates)
                            <ul data-manager-id="{{ $employee->user_id }}" style="display: none;">
                                @foreach ($employees as $subordinate)
                                    @if ($subordinate->reporting_manager == $employee->user_id)
                                        <li>
                                            @php
                                                $hasSubSubordinates = false;
                                                foreach ($employees as $subSubordinate) {
                                                    if ($subSubordinate->reporting_manager == $subordinate->user_id) {
                                                        $hasSubSubordinates = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @if ($hasSubSubordinates)
                                                <button class="toggle-button" data-user-id="{{ $subordinate->user_id }}" onclick="toggleChildren(this)">+</button>
                                            @endif
                                            <span onclick="displayEmployeeDetails(
                                                '{{ $subordinate->user_id }}',
                                                '{{ $subordinate->employee_name }}',
                                                '{{ $subordinate->designation }}',
                                                '{{ $subordinate->employee_no }}',
                                                '{{ $subordinate->reporting_manager_name }}',
                                                '{{ $subordinate->department }}',
                                                '{{ $subordinate->per_city }}',
                                                '{{ $subordinate->offical_phone_number }}',
                                                '{{ $subordinate->offical_email_address }}'
                                            )">
                                                {{ $subordinate->employee_name }}
                                            </span>
                                            @if ($hasSubSubordinates)
                                                <ul data-manager-id="{{ $subordinate->user_id }}" style="display: none;">
                                                    @foreach ($employees as $subSubordinate)
                                                        @if ($subSubordinate->reporting_manager == $subordinate->user_id)
                                                            <li>
                                                                <span onclick="displayEmployeeDetails(
                                                                    '{{ $subSubordinate->user_id }}',
                                                                    '{{ $subSubordinate->employee_name }}',
                                                                    '{{ $subSubordinate->designation }}',
                                                                    '{{ $subSubordinate->employee_no }}',
                                                                    '{{ $subSubordinate->reporting_manager_name }}',
                                                                    '{{ $subSubordinate->department }}',
                                                                    '{{ $subSubordinate->per_city }}',
                                                                    '{{ $subSubordinate->offical_phone_number }}',
                                                                    '{{ $subSubordinate->offical_email_address }}'
                                                                )">
                                                                    {{ $subSubordinate->employee_name }}
                                                                </span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>  
    </div>  
    <div class="employee-details">  
        <div class="left">  
            <div class="heading">Employee Profile</div>  
            <?php 
            $profileimahe = session('profile_image');
            
            ?>
            <div class="profile-circle">  
                <img id="profile-image" src="{{ asset('storage/'.$profileimahe) }}" alt="Profile">   
            </div>  
            <div class="emp-name" id="emp-name">Name</div>  
            <div class="emp-designation" id="emp-designation">Designation</div>  
        </div>  
        <div class="right">  
            <div class="detail-item"><span>Employee No:</span> <span id="emp-no">12345</span></div>  
            <div class="detail-item"><span>Reporting Manager:</span> <span id="emp-manager">Manager</span></div>  
            <div class="detail-item"><span>Department:</span> <span id="emp-department">HR</span></div>  
            <div class="detail-item"><span>City:</span> <span id="emp-city">New York</span></div>  
            <div class="detail-item"><span>Phone:</span> <span id="emp-phone">123-456-7890</span></div>  
            <div class="detail-item"><span>Email:</span> <span id="emp-email">employee@example.com</span></div>  
        </div>  
    </div>  
</div>  

<script>  
    // Function to toggle visibility of employee children  
    function toggleChildren(button) {  
        var userId = button.getAttribute('data-user-id');  
        var children = document.querySelectorAll(`[data-manager-id='${userId}']`);  
        children.forEach(child => {  
            child.style.display = (child.style.display === 'none') ? 'block' : 'none';  
        });  
        button.innerText = (button.innerText === '-') ? '+' : '-';  
    }  

    function displayEmployeeDetails(userId, name, designation, empNo, manager, department, city, phone, email) {  
        document.getElementById('emp-name').textContent = name;  
        document.getElementById('emp-designation').textContent = designation;  
        document.getElementById('emp-no').textContent = empNo;  
        document.getElementById('emp-manager').textContent = manager;  
        document.getElementById('emp-department').textContent = department;  
        document.getElementById('emp-city').textContent = city;  
        document.getElementById('emp-phone').textContent = phone;  
        document.getElementById('emp-email').textContent = email;  
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
            window.location.href = '../orgnizationchart/org.php';  
        }  
        // Default behavior for vertical chart can be handled without alert  
    }  

    // Set default selected option to "Vertical" and display employee details on load  
    window.onload = function() {  
        document.getElementById('display-option').value = 'vertical'; // Set default to Vertical chart  

        // Get the employee details from Laravel session
        const empNo = "{{ Auth::user()->employee_no }}";
        const empName = "{{ Auth::user()->employee_name }}";
        const empDesignation = "{{ Auth::user()->designation }}";
        const empManager = "{{ Auth::user()->reporting_manager_name }}"; // Ensure this is the manager's name
        const empDepartment = "{{ Auth::user()->department }}";
        const empCity = "{{ Auth::user()->per_city }}";
        const empPhone = "{{ Auth::user()->offical_phone_number }}";
        const empEmail = "{{ Auth::user()->offical_email_address }}";

        // Call the function to display the employee details  
        displayEmployeeDetails(empNo, empName, empDesignation, empNo, empManager, empDepartment, empCity, empPhone, empEmail);  
    };  
</script>
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
        width: 95%;
        max-width: 1500px;
        background-color: #f5f5f5;
        border-radius: 15px;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        height: 550px;
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
        width: 30%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: 300px;
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

    .employee-details .left .profile-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #ddd;
        margin: 0 auto 15px;
        overflow: hidden;
    }

    .employee-details .left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .employee-details .right {
        width: 70%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 15px;
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
        background-color: #8A3366;
        font-weight: bold;
        color: white;
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
</style>
@endsection

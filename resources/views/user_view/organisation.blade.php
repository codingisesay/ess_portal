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
                echo '<img src="' . asset('user_end/images/man2.png') . '" alt="Male" style="width:18px; height:18px; margin-right: 5px;">';
            } elseif ($employee->gender == 'Female') {
                echo '<img src="' . asset('user_end/images/woman.png') . '" alt="Female" style="width:18px; height:18px; margin-right: 5px;">';
            } else {
                echo '<img src="' . asset('user_end/images/male-and-female.png') . '" alt="Gender Neutral" style="width:18px; height:18px; margin-right: 5px;">'; // You can use a gender-neutral icon here if needed
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
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- {{-- <title>Organisation Chart</title> --}} -->
    <link rel="icon" href= "../resource/image/common/STPLLogo butterfly.png" />
    <link rel="stylesheet" href="{{ asset('/user_end/css/organisation.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
<div class="mx-4 mt-3">
    <div class="header mb-4">
        <!-- <h4>Organization Hierarchy</h4> -->
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
    
    <div class=" row">  
        <div class="col-md-4">
            <div class="employee-list">
                <ul class="tree">
                    @foreach ($employeeHierarchy as $employee)
                        {!! renderEmployeeNode($employee) !!}
                    @endforeach
                </ul>
            </div>  
        </div>
            <div class="col-md-8"> 
                <div class="employee-details ">  
                    <div class="left">  
                        @include('user_view.employment_details_top')
                    </div> 
                    <div class="right"> 
                        <!-- Include employment details section -->
                        @include('user_view.employment_details_section')
                    </div>

                </div>  
            </div>
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
@endsection
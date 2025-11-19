@extends('user_view.header')
@section('content')

<?php
function renderEmployeeTree($employees) {
    echo '<ul>';
    foreach ($employees as $employee) { 

        echo '<li class="employee" data-emp-id="' . $employee->user_id . '" data-manager-id="' . ($employee->reporting_manager ?? '') . '">';
        // choose gender icon to display in place of profile image
        $genderIcon = asset('user_end/images/male-and-female.png');
        if (isset($employee->gender)) {
            if ($employee->gender === 'Male') {
                $genderIcon = asset('user_end/images/man2.png');
            } elseif ($employee->gender === 'Female') {
                $genderIcon = asset('user_end/images/woman.png');
            }
        }

        echo '<div class="profile-container"> ';
        // original profile image (kept as comment for easy restore)
        echo '    <img class=" profile-img" src="' 
            . (isset($employee->profile_image) && !empty($employee->profile_image) 
            ? asset('storage/' . $employee->profile_image) : '/storage/user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg') 
            . '" alt="Profile Image"> <br/>';
        // show gender icon in the image spot (above the name)
        // echo '    <img class=" profile-img" src="' . $genderIcon . '" alt="Gender Icon" style="width:50px; height:50px; border-radius:50%;"> <br/>';
        echo ' <small class="emp-name">' . $employee->employee_name . '</small>';
        echo '    <div class="emp-info"> ';
        echo '        <div class=""> Dept - ' . $employee->department . '</div> ';
        echo '        <h6 class="emp-name mb-0">' . $employee->employee_name . '</h6> ';
        echo '        <div class="emp-designation"> Role - ' . $employee->designation . '</div> ';
        echo '    </div> ';
        echo '</div>  ';

 
        if (!empty($employee->subordinates)) {
            renderEmployeeTree($employee->subordinates);
        }
        
        echo '</li>';
    }
    echo '</ul>';
}
?>
 
 
    <title>Organizational Chart</title>
 
    <link rel="stylesheet" href="{{ asset('/user_end/css/organisation.css') }}">
   
    
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
        <div class="scroll-container">
            <div class="tree" id="employee-tree">
                {!! renderEmployeeTree($employeeHierarchy) !!}
            </div>
        </div>
    </div>
    <script>
        // This script is for toggling visibility of subordinates and search functionality
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('search');

            // Search functionality
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const employees = document.querySelectorAll('.employee');

                if (!query) {
                    employees.forEach(emp => emp.style.display = 'block');
                    return;
                }

                employees.forEach(emp => {
                    const empName = emp.querySelector('.emp-name').textContent.toLowerCase();
                    emp.style.display = empName.includes(query) ? 'block' : 'none';
                });
            });

            // Toggle functionality for showing/hiding subordinates
            const employeeCards = document.querySelectorAll('.employee-box');

            employeeCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parentLi = this.parentElement;
                    const childUl = parentLi.querySelector('ul');

                    if (childUl) {
                        childUl.style.display = childUl.style.display === 'none' ? 'block' : 'none';
                    }
                });
            });
        });
        
        function changeDisplayMode() {  
            const displayOption = document.getElementById('display-option').value;  

            if (displayOption === 'vertical') {  
                // Redirect to org.php when horizontal chart is selected  
                window.location.href = "{{ route('user.view_organisation') }}"; 
                
            }  
            // Default behavior for vertical chart can be handled without alert  
        }  

        function highlightEmployee() {  
            const searchQuery = document.getElementById('search-bar').value.toLowerCase();  
            const employees = document.querySelectorAll('.emp-name');  
            

            employees.forEach(employee => {  
                // Highlight matching names or remove highlight  
                if (searchQuery && employee.textContent.toLowerCase().includes(searchQuery)) {  
                    employee.classList.add('highlight');  
                } else {  
                    employee.classList.remove('highlight');  
                }  
            });  
        }  


    </script>
 
@endsection 
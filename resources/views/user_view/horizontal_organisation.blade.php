@extends('user_view.header')
@section('content')

<?php
function renderEmployeeTree($employees) {
    echo '<ul>';
    foreach ($employees as $employee) {
        echo '<li class="employee" data-emp-id="' . $employee->user_id . '" data-manager-id="' . ($employee->reporting_manager ?? '') . '">';
        echo '<div class="employee-box">';
        echo '<div class="department" style="background-color: ' . ($employee->department_color ?? '#8A3366') . ';">' . $employee->department . '</div>';
        echo '<div class="profile-container"><img src="' . (isset($employee->profile_image) && !empty($employee->profile_image) ? asset('storage/' . $employee->profile_image) : '/storage/user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg') . '" alt="Profile Image" class="profile-img"></div>';
        echo '<div class="emp-info"><div class="emp-name">' . $employee->employee_name . '</div>';
        echo '<div class="emp-designation">' . $employee->designation . '</div></div>';
        echo '</div>';
        
        if (!empty($employee->subordinates)) {
            renderEmployeeTree($employee->subordinates);
        }
        
        echo '</li>';
    }
    echo '</ul>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizational Chart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General styles for the tree structure */
        * { margin: 1px; padding: 0; color: black; }

        /* Header styling */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
            background-color: #f6F5F7;
            border-radius: 15px;
            margin-bottom: 7px;
        }

        .header h1 {
            font-size: 30px;
            font-weight: bold;
            color: #333;
            width: 393px;
            height: 48px;
        }

        /* Search box styling */
        .search-box {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border: solid #FFFFFF 5px;
            height: 48px;
            width: 250px;
            position: relative;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            padding: 0 10px;
            font-size: 14px;
            color: #333;
        }

        /* Search button styling */
        .search-box button {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            width: 30px;  /* Size of the circle */
            height: 30px;  /* Size of the circle */
            border-radius: 50%;  /* Makes the button circular */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #8A3366;  /* Optional: background color for the circle */
        }

        .search-box button img {
            width: 16px;  /* Adjust image size to fit inside the circle */
            height: 16px;  /* Adjust image size to fit inside the circle */
        }

        /* Scroll container styling */
        .scroll-container {
            /* max-height: 500px; Set desired height */
        overflow-y: auto;  /* Enable vertical scrolling */
        overflow-x: auto; /* Disable horizontal scrolling if needed */
        border: 1px solid #ccc; /* Optional: Add a border for visibility */
        padding: 10px;
        }

        /* Tree structure styling */
        .tree {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            margin-left: 20px;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row; /* Keep employees aligned horizontally */
            justify-content: center;
        }

        .tree li {
            list-style-type: none;
            position: relative;
            padding: 10px;
            text-align: center;
            transition: all 0.5s;
        }

        /* Tree connectors (lines between levels) */
        .tree li::before, .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #8A3366; /* Color and thickness of the line */
            width: 50%;
            height: 20px;
            transition: all 0.3s ease;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #8A3366; /* Color and thickness of the line */
        }

        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before, .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid #8A3366;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        /* Profile image styling */
        .tree li .profile-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #f0f0f0;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
        
            /* border: 1px solid #ccc; */
        }

        .tree li .profile-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .tree li .employee-box {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            border-radius: 15px;
            width: 200px;
            height: 150px;
            background-color: #FFF;
        }

        .tree li .emp-info {
            text-align: center;
        }

        /* Add vertical lines for nested 'ul' */
.tree ul ul {
    position: relative;
    margin-top: 20px;
}

.tree ul ul::before {
    content: '';
    position: absolute;
    top: -22px;
    left: 50%;
    border-left: 2px solid #8A3366; /* Vertical connector line */
    height: 25px;
    width: 0;
}


        .department {
            font-weight: bold;
            font-size: 12px;
            color: #fff;
            margin-bottom: 5px;
            padding: 5px;
            border-radius: 5px;
            width: 200px;
            margin-left: -10px;
            margin-top: -5px;
            height: 20px;
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

    .tree-main{
        overflow: auto;
    }

    </style>
</head>
<body>
<div class="header">
    <h1>Organization Hierarchy</h1>
    <div class="dropdown">
        <select id="display-option" onchange="changeDisplayMode()">
            <option value="horizontal">Horizontal Organization Chart</option>
            <option value="vertical">Vertical Organization Chart</option>
        </select>
    </div>
    <div class="search-box">
        <input type="text" id="search-bar" placeholder="Search Employee Name..."  onkeyup="highlightEmployee()" />
        <button type="button">
            <!-- <img src="../resource/image/common/search (1).png" alt="Search" /> -->
            <span class="search-icon"> <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon"></span>
        </button>
    </div>
</div>
<div class="scroll-container">
    <div class="tree" id="employee-tree">
        {!! renderEmployeeTree($employeeHierarchy) !!}
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


<style>
    .highlight {
    background-color: #E0AFA0;
    font-weight: bold;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>
@endsection
</body>
</html>


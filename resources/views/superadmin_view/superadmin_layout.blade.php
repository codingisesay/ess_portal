<?php 

$name = Auth::guard('superadmin')->user()->name;

?>
<!DOCTYPE html>
<html>
<head>
<title>Superadmin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
<style>

body {
    display: flex;
    height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f6f6f6;
    color: #333;
}

.sidebar {
    width: 315px;
    background-color: #F6F5F7;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    margin-left: -50px; /* Move sidebar slightly to the left */
    height: 100vh;
    margin-top: -50px;
    overflow: auto

}

.logo img {
    height: 50px;
    margin-bottom: 20px;
}

nav ul {
    list-style: none;
    padding: 0;
    width: 100%;
}

nav ul li {
    margin-bottom: 20px;
}

nav ul li a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #b1b1b1;
    text-decoration: none;
    transition: color 0.3s ease;
}

nav ul li a.active,
nav ul li a:hover {
    color: #8A3366;
    font-weight: bold;
}

.sidebar-icons {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.searchcircle,
.bellcircle,
.profilecircle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #F6F5F7;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logout-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #F6F5F7;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

.logout-button:hover {
    background-color: #ddd;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        margin-left: 0;
        border-radius: 0;
    }

    .logo img {
        height: 40px;
    }

    nav ul li {
        margin-bottom: 15px;
    }

    .searchcircle,
    .bellcircle,
    .profilecircle {
        width: 40px;
        height: 40px;
    }
}
</style>
</head>
<body class="body">

<!-- Top container -->
<a href="{{ route('superadmin.logout') }}" class="logout-button">Logout</a>

<script>
    var successMessage = @json(session('success'));
    var errorMessage = @json(session('error'));
</script>
<!-- Sidebar/menu -->
<nav class="sidebar" id="mySidebar"><br>
  <div class="sidebar-header">
    <div class="logo">
    <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="STPL Logo">
    </div>
    
  </div>
  <hr>
  <div class="sidebar-content">
    <ul>
        <!-- Organisation Configuration -->
        <li>
            <strong onclick="toggleDropdown('orgConfigDropdown', this)">
                Organisation Configuration <span class="dropdown-arrow">&#9660;</span>
            </strong>
            <ul id="orgConfigDropdown" style="display: none;">
			    <li><a href="{{ route('create_user') }}" class="active"><img src="{{ asset('admin_end/images/man.png') }}" width="30" height="30" alt=""> Create User</a></li>
                <li><a href="{{ route('create_branch_form') }}"><img src="{{ asset('admin_end/images/createbranch.png') }}" width="30" height="30" alt=""> Create Branch</a></li>
                <li><a href="{{ route('create_department_form') }}"><img src="{{ asset('admin_end/images/corporation.png') }}" width="30" height="30" alt=""> Create Department</a></li>
                <li><a href="{{ route('create_designation_form') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Create Designation</a></li>
            </ul>
        </li>

        <!-- Policy Management -->
        <li>
            <strong onclick="toggleDropdown('policyManagementDropdown', this)">
                Policy Management <span class="dropdown-arrow">&#9660;</span>
            </strong>
            <ul id="policyManagementDropdown" style="display: none;">
                <li><a href="{{ route('create_policy_category') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Create Policy Category</a></li>
                <li><a href="{{ route('create_hr_policy') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Create HR Policy</a></li>
                <li><a href="{{ route('create_policy_time_slot') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Leave Policy Slot</a></li>
                <li><a href="{{ route('create_policy_type') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Leave Policy Type</a></li>
                <li><a href="{{ route('create_policy') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Leave Policy Creation</a></li>
                <li><a href="{{ route('employee_policy') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Leave Emp Policy</a></li>
                <li><a href="{{ route('process_leave_policy') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Process Leave Cycle</a></li>
            </ul>
        </li>

        <!-- Salary Management -->
        <li>
            <strong onclick="toggleDropdown('salaryManagementDropdown', this)">
                Salary Management <span class="dropdown-arrow">&#9660;</span>
            </strong>
            <ul id="salaryManagementDropdown" style="display: none;">
                <li><a href="{{ route('salary_template_form') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Create Salary Templates</a></li>
                <li><a href="{{ route('create_salary_components') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Salary Template Components</a></li>
            </ul>
        </li>

        <!-- Tax Management -->
        <li>
            <strong onclick="toggleDropdown('taxManagementDropdown', this)">
                Tax Management <span class="dropdown-arrow">&#9660;</span>
            </strong>
            <ul id="taxManagementDropdown" style="display: none;">
                <li><a href="{{ route('tax_cycle') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Tax Cycle</a></li>
                <li><a href="{{ route('taxes') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Taxes</a></li>
            </ul>
        </li>

        <!-- Settings -->
        <li>
            <strong onclick="toggleDropdown('settingsDropdown', this)">
                Settings <span class="dropdown-arrow">&#9660;</span>
            </strong>
            <ul id="settingsDropdown" style="display: none;">
                <li><a href="{{ route('load_mail_config_form') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt=""> Mail Settings</a></li>
            </ul>
        </li>
    </ul>
  </div>
</nav>

<script>
    function toggleDropdown(id, element) {
        const dropdown = document.getElementById(id);
        const arrow = element.querySelector('.dropdown-arrow');
        if (dropdown.style.display === 'none') {
            dropdown.style.display = 'block';
            arrow.innerHTML = '&#9650;'; // Up arrow
        } else {
            dropdown.style.display = 'none';
            arrow.innerHTML = '&#9660;'; // Down arrow
        }
    }
</script>

  @yield('content')
  

</div>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(function(link) {
                link.classList.remove('active');
            });
            var currentPage = window.location.pathname.split('/').pop();
            navLinks.forEach(function(link) {
                var linkPath = link.getAttribute('href').split('/').pop();
                if (linkPath === currentPage) {
                    link.classList.add('active');
                }
            });
            
        });
    </script>

</body>
</html>

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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=settings" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_forward" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
<style>

body {
    display: flex;
    height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #F6F5F7;
    color: #333;
}
 
::-webkit-scrollbar {
    width: 5px;
}
 
::-webkit-scrollbar-track {
    -webkit-box-shadow: none  ;
}
 
::-webkit-scrollbar-thumb {
  background-color: #EDEDEE; 
  border-radius:30px
}
.sidebar {
    width: 330px;
    background-color: #FFF;
    /* display: flex; */
    /* flex-direction: column; */
    /* align-items: center; */
    padding: 10px;
    box-shadow: 0px 6px 6px 0px #00000040;
    /* border-radius: 15px; */
    /* margin-left: -50px; */
    height: 100vh;
    /* margin-top: -50px; */
    overflow: auto;
}
.sidebar::-webkit-scrollbar {
  display: none;
}
.sidebar-header{display: flex;
    align-items: center;
    justify-content: space-between;
    background: #F6F5F7;padding: 7px 20px;
    border-radius:6px;
    box-shadow: 0px 0px 4px 0px #00000040;
}
.logo img {
    height: auto;width: 45%; 
}
img.active-dd{ 
    transform: rotate(90deg);
}
nav ul {
    list-style: none;
    padding: 20px 10px;
    width: 100%;
}
nav ul li ul{padding:10px 0 0 0;}
nav ul li ul li{margin:0}
nav ul li ul li a{padding: 7px 15px 7px 33px}
nav ul li a.active{background: #8A33664D;box-shadow: 0px 0px 4px 0px #00000040;border-radius: 6px;}
nav ul li {
    margin-bottom: 20px;
}

nav ul li a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #656565; 
    text-decoration: none;
    transition: color 0.3s ease;
}

nav ul li a.active,
nav ul li a:hover {
    color: #8A3366;
    font-weight: bold;
}
.nav-list{margin:0}
.sidebar-content{height:75vh; overflow:auto;margin:5px 0}
.sidebar-content ul li strong img{opacity: .58;}
.sidebar-content ul li strong{ color:#656565; display : flex; justify-content: space-between;align-items: center; cursor: pointer;font-weight: 500; }
.header-arrow{box-shadow: 0px 0px 4px 0px #00000040; background: #FFF;border-radius:50%; padding: 1px 
}
.sidebar-footer small{font-size:10px;}
.sidebar-footer{
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
    padding: 10px;
    background-color: #F6F5F7;
    border-radius: 6px;
    box-shadow: 0px 0px 4px 0px #00000040;
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
<nav class="sidebar" id="mySidebar">
  <div class="sidebar-header">
    <div class="logo">
    <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="STPL Logo">
    </div>
    <img src="{{ asset('user_end/images/arrow-right.svg') }}" class="header-arrow" alt="arrow">
  </div> 
  <div class="sidebar-content">
    <ul class="nav-list">
        <!-- Organisation Configuration -->
        <li>
            <strong onclick="toggleDropdown('orgConfigDropdown', this)">
            <strong> <span class="material-symbols-outlined">settings </span>&nbsp;   Organisation Configuration</strong>
            <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow"  class="dropdown-arrow"> 
            </strong>
            <ul id="orgConfigDropdown" style="display: none;">
			    <li><a href="{{ route('create_user') }}" class="active">  Create User</a></li>
                <li><a href="{{ route('create_branch_form') }}"> Create Branch</a></li>
                <li><a href="{{ route('create_department_form') }}">  Create Department</a></li>
                <li><a href="{{ route('create_designation_form') }}">  Create Designation</a></li>
            </ul>
        </li>

        <!-- Policy Management -->
        <li>
            <strong onclick="toggleDropdown('policyManagementDropdown', this)">
            <strong> <span class="material-symbols-outlined">settings </span>&nbsp;   Policy Management </strong>
                <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow"  class="dropdown-arrow"> 
            </strong>
            <ul id="policyManagementDropdown" style="display: none;">
                <li><a href="{{ route('create_policy_category') }}">  Create Policy Category</a></li>
                <li><a href="{{ route('create_hr_policy') }}">  Create HR Policy</a></li>
                <li><a href="{{ route('create_policy_time_slot') }}">  Leave Policy Slot</a></li>
                <li><a href="{{ route('create_policy_type') }}">  Leave Policy Type</a></li>
                <li><a href="{{ route('create_policy') }}">  Leave Policy Creation</a></li>
                <li><a href="{{ route('employee_policy') }}">  Leave Emp Policy</a></li>
                <li><a href="{{ route('process_leave_policy') }}">  Process Leave Cycle</a></li>
            </ul>
        </li>

        <!-- Salary Management -->
        <li>
            <strong onclick="toggleDropdown('salaryManagementDropdown', this)">
            <strong> <span class="material-symbols-outlined">settings </span>&nbsp;  Salary Management   </strong>
               <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow"  class="dropdown-arrow"> 
            </strong>
            <ul id="salaryManagementDropdown" style="display: none;">
                <li><a href="{{ route('salary_template_form') }}">  Create Salary Templates</a></li>
                <li><a href="{{ route('create_salary_components') }}">  Salary Template Components</a></li>
            </ul>
        </li>

        <!-- Tax Management -->
        <li>
            <strong onclick="toggleDropdown('taxManagementDropdown', this)">
            <strong> <span class="material-symbols-outlined">settings </span>&nbsp;    Tax Management </strong>
               <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow"  class="dropdown-arrow"> 
            </strong>
            <ul id="taxManagementDropdown" style="display: none;">
                <li><a href="{{ route('tax_cycle') }}">  Tax Cycle</a></li>
                <li><a href="{{ route('taxes') }}">  Taxes</a></li>
            </ul>
        </li>

        <!-- Settings -->
        <li>
            <strong onclick="toggleDropdown('settingsDropdown', this)">
            <strong> <span class="material-symbols-outlined">settings </span>&nbsp; Settings  </strong>
            <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow"  class="dropdown-arrow"> 
            </strong>
            <ul id="settingsDropdown" style="display: none;">
                <li><a href="{{ route('load_mail_config_form') }}">  Mail Settings</a></li>
            </ul>
        </li>
    </ul>
  </div>

  <div class="sidebar-footer">
        <img  src="{{ asset('admin_end/images/support.png') }}" alt="">
        <div>
        <strong>Need Help?</strong> <br>
        <small>Go to Help Center 
        <small class="material-symbols-outlined mt-2">arrow_forward</small> 
        </small>
       
        </div>
    </div>
</nav>

<script>
    // function toggleDropdown(id, element) {
    //     const dropdown = document.getElementById(id);
    //     const arrow = element.querySelector('.dropdown-arrow');
    //     if (dropdown.style.display === 'none') {
    //         dropdown.style.display = 'block';
    //         arrow.innerHTML = `<img class="active-dd" src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow">`; // Up arrow
    //     } else {
    //         dropdown.style.display = 'none';
    //         arrow.innerHTML = `<img class="active-dd" src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow">`; // Down arrow
    //     }
    // }

    function toggleDropdown(id, element) {
    const dropdown = document.getElementById(id);
    const arrow = element.querySelector('.dropdown-arrow');

    // Toggle the dropdown display
    if (dropdown.style.display === 'none') {
        dropdown.style.display = 'block';
        // Rotate the arrow 90 degrees to point down (or up, depending on initial state)
        arrow.style.transform = 'rotate(90deg)';
    } else {
        dropdown.style.display = 'none';
        // Reset the rotation back to 0 degrees
        arrow.style.transform = 'rotate(0deg)';
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

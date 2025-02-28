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
    width: 250px;
    background-color: #F6F5F7;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    margin-left: -10px; /* Move sidebar slightly to the left */
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
        <li><a href="{{ route('create_user') }}" class="active"><img src="{{ asset('admin_end/images/man.png') }}" width="30" height="30" alt=""> Create User</a></li>
            <li><a href="{{ route('create_branch_form') }}"><img src="{{ asset('admin_end/images/createbranch.png') }}" width="30" height="30" alt=""> Create Branch</a></li>
            <li><a href="{{ route('create_department_form') }}"><img src="{{ asset('admin_end/images/corporation.png') }}" width="30" height="30" alt=""> Create Department</a></li>
            <li><a href="{{ route('create_designation_form') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt="">  Create Designation</a></li>
            <li><a href="{{ route('load_mail_config_form') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt="">  Mail Settings</a></li>
            <li><a href="{{ route('create_policy_category') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt="">  Create Policy Category</a></li>
            <li><a href="{{ route('create_hr_policy') }}"><img src="{{ asset('admin_end/images/createdesignation.png') }}" width="30" height="30" alt="">  Create HR Policy</a></li>
          </ul>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<!-- <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div> -->

<!-- !PAGE CONTENT! -->

  @yield('content')
  
  <!-- Footer -->
  <!-- <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer> -->

  <!-- End page content -->
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

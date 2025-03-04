<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="STPL Logo">
        </div>
        <!-- 🔹 MENU BUTTON -->
        <button class="menu-btn"><i class="fas fa-bars"></i></button>
        <nav>
            <ul>
                <li><a href="{{ route('user.homepage') }}" class="active"><img src="{{ asset('user_end/images/dashboard icon.svg') }}" width="30" height="30" alt="">Dashboard</a></li>
                <li><a href="{{ route('user.employment.data') }}"><img src="{{ asset('user_end/images/man.png') }}" width="30" height="30" alt="">Employee Details</a></li>
                <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/logout (1).png') }}" width="30" height="30" alt="">Leave & Attendance</a></li>
                <li><a href="{{ route('user.view_organisation') }}"><img src="{{ asset('user_end/images/speedometer (1).png') }}" width="30" height="30" alt="">Orgnizations Chart</a></li>
                {{-- <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/security.png') }}" width="30" height="30" alt="">PMS</a></li> --}}
                <li><a href="{{ route('user.hr.policy') }}"><img src="{{ asset('user_end/images/succession.png') }}" width="30" height="30" alt="">HR Policy</a></li>
                <li><a href="{{ route('user.setting') }}"><img src="{{ asset('user_end/images/settings.png') }}" width="30" height="30" alt="">Settings</a></li>
            </ul>
        </nav>
        <script>
            // 🔹 Toggle Navbar on Click
            document.querySelector(".menu-btn").addEventListener("click", function () {
                document.querySelector("nav").classList.toggle("active");
            });
        </script>
        <div class="header-icons">
            <div class="searchcircle">
                <a href="search.html">
                    <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search Icon" style="height: 20px; vertical-align: middle;">
                </a>
            </div>
            <div class="bellcircle">  
                <a href="bell.html">
                    <img src="{{ asset('user_end/images/bell.png') }}" alt="Bell Icon" style="height: 20px; vertical-align: middle;">
                </a>
            </div>
            <div class="profilecircle">
                <a href="javascript:void(0)" id="profileIcon">
                    <img src="" class="profile-pic" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;">
                </a>
            </div>
        </div>
    </header>

    @yield('content');

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get all navigation links
            var navLinks = document.querySelectorAll('nav ul li a');

            // Initially remove the active class from all links
            navLinks.forEach(function (link) {
                link.classList.remove('active');
            });

            // Get the current page's filename
            var currentPage = window.location.pathname.split('/').pop();

            // Loop through each link and check if its href matches the current page
            navLinks.forEach(function (link) {
                var linkPath = link.getAttribute('href').split('/').pop();

                // If the current page matches the link's href, add the 'active' class
                if (linkPath === currentPage) {
                    link.classList.add('active');
                }
            });

            // If no page matches (like the user is on the default page), add the active class to Dashboard
            if (currentPage === '' || currentPage === 'ESS_HOME.php' || currentPage === 'ESS_HOME.PHP') {
                // Ensure Dashboard is highlighted on the first login
                navLinks[0].classList.add('active');
            }
        });
    </script>

    <!-- Profile Popup -->
    <div id="profilePopup" class="popup-container">
        <div class="popup-content">
            <button class="close-btn" id="closePopup">&times;</button>
            <h3>Employee Profile Information</h3>
            <div class="profile-pic-section">
                <form id="profilePicForm" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profilePic" id="profilePicInput" style="display: none;">
                    <button type="button" class="change-profile" id="changeProfileBtn">Change Profile</button>
                    <button type="submit" class="save-profile" style="display: none;" id="saveProfileBtn">Save</button>
                </form>
            </div>
            <form id="profileForm">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" value="{{ htmlspecialchars($employee_data['Employee_Name'] ?? '') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="contactNo">Contact No.</label>
                    <input type="text" id="contactNo" value="{{ htmlspecialchars($employee_data['Phone_Number'] ?? '') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="text" id="dob" value="{{ htmlspecialchars($employee_data['Date_of_Birth'] ?? '') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email Id</label>
                    <input type="email" id="email" value="{{ htmlspecialchars($employee_data['Email_ID'] ?? '') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" id="designation" value="{{ htmlspecialchars($employee_data['Designation'] ?? '') }}" readonly>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show the profile popup and fetch employee details using AJAX
        document.getElementById('profileIcon').addEventListener('click', function () {
            document.getElementById('profilePopup').style.display = 'flex';
            fetchEmployeeDetails();  // Fetch data when popup is opened
        });

        // Close the popup when the close button is clicked
        document.getElementById('closePopup').addEventListener('click', function () {
            document.getElementById('profilePopup').style.display = 'none';
        });

        // Close the popup when clicking outside the popup content
        window.addEventListener('click', function (event) {
            if (event.target === document.getElementById('profilePopup')) {
                document.getElementById('profilePopup').style.display = 'none';
            }
        });
    </script>
</body>

</html>
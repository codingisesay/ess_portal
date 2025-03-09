<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <style>
        /* Add your custom CSS here */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 77px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 10px;
            overflow: hidden;
        }

        .profile-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .profile-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        .profile-dropdown:hover .profile-pic {
            border: 2px solid #8A3366;
        }

        .profile-pic {
            cursor: pointer;
        }

        .logout-icon, .camera-icon {
            background-color: transparent;
            border: none;
            color: #8A3366;
            font-size: 20px;
            cursor: pointer;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .logout-icon:hover, .camera-icon:hover {
            color: #6a2a52;
        }
    </style>
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
                <li><a href="{{ route('leave_dashboard') }}"><img src="{{ asset('user_end/images/logout (1).png') }}" width="30" height="30" alt="">Leave & Attendance</a></li>
                {{-- <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/speedometer (1).png') }}" width="30" height="30" alt="">Orgnizations Chart</a></li>
                <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/logout (1).png') }}" width="30" height="30" alt="">Leave & Attendance</a></li> --}}
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
            <div class="profilecircle profile-dropdown">
                <a href="javascript:void(0)" id="profileIcon">
                    <img src="" class="profile-pic" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;">
                </a>
                <div class="profile-dropdown-content">
    <!-- Logout Form -->
    <form action="{{ route('user.logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-icon">
            <i class="fas fa-power-off"></i>
        </button>
    </form>

    <!-- Camera Icon to Trigger File Upload -->
    <button class="camera-icon" onclick="document.getElementById('profile-photo-upload').click();">
        <i class="fas fa-camera"></i>
    </button>

    <!-- Hidden File Input for Image Upload -->
    <form id="profile-upload-form" action="{{ route('user.uploadProfilePhoto') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- The file input is hidden, but it will be triggered by the camera icon -->
        <input type="file" id="profile-photo-upload" name="profile_image" accept="image/*" style="display:none;" onchange="this.form.submit();">
    </form>
</div>


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
</body>

</html>
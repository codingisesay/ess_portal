<?php 

// // dd($userData);
// echo $userData->imagelink;
// exit();

$profileimahe = session('profile_image');
$userDetails = app('App\Http\Controllers\headerController')->getUserDetails();


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo.png') }}" type="image/png">
    <title>@isset($title){{ $title }}@else{{ 'ESS Portal' }}@endisset</title>
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
</head>
<body>

    <script>
        var successMessage = @json(session('success'));
        var errorMessage = @json(session('error'));
    </script>
    <header>
        <div class="logo">
            <img class="px-1" src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="STPL Logo">
        </div>
        <!-- 🔹 MENU BUTTON -->
        <button class="menu-btn"><x-icon name="menu"/></button>
        <nav>
            <ul>
                <li><a href="{{ route('user.homepage') }}" class="active"> <x-icon name="dashboard" />Dashboard</a></li>
                <li><a href="{{ route('user.employment.data') }}"> <x-icon name="userdetails" />Employee Details</a></li>
                <li><a href="{{ route('PayRollDashboard') }}"> <x-icon name="pay" />Payroll</a></li>
                <li><a href="{{ route('leave_dashboard') }}"> <x-icon name="attendance" />Leave & Attendance</a></li> 
                <li><a href="{{ route('user.view_organisation') }}"> <x-icon name="chart" />Orgnizations Chart</a></li> 
                <li><a href="{{ route('user.hr.policy') }}"> <x-icon name="policyfill" />HR Policy</a></li>
                 <li><a href="{{ route('pms_dashboard') }}"> <x-icon name="chart" />PMS Dashboard</a></li> 
                <li><a href="{{ route('user.setting') }}"> <x-icon name="settingfill" />Settings</a></li>
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
                <a href="search.html" class="text-dark mx-2">
                   <x-icon name="search" />
                </a>
            </div>
            <div class="bellcircle"> 
                <!-- Notification dropdown toggled on bell click -->
                <a href="javascript:void(0)" id="notificationIcon" class="text-dark mx-2">
                  <x-icon name="notification" />
                </a>
                <div id="notificationDropdown" class="dropdown-content-notifications" style="display:none; min-width:260px;">
                    <div class="px-2 py-2"><strong>Notifications</strong></div>
                    <hr class="my-1"/>
                    <div class="px-2 pb-2 text-muted"><small>No notifications yet.</small></div>
                </div>
            </div>
            <!-- Profile Circle - Displays user's profile picture or default icon -->
            <div class="profilecircle profile-dropdown">
                <a href="javascript:void(0)" id="profileIcon" class="mx-2" > 
                    {{-- Check if user has a profile image and it exists in storage --}}
                    @if(!empty($userDetails->profile_image) && file_exists(public_path('storage/' . $userDetails->profile_image)))
                        {{-- Display user's profile image --}}
                        <img src="{{ asset('storage/' . $userDetails->profile_image) }}" 
                             alt="Profile Picture" 
                             class="header-profile" 
                             style="border-radius: 50%; object-fit: cover; width: 40px; height: 40px;">
                    @else
                        {{-- Fallback: Display default user icon if no profile image exists --}}
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" 
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </a>
                <!-- Profile Dropdown Content -->
                <div class="profile-dropdown-content"> 
                    <div class="d-flex align-items-center">
                        {{-- Profile picture in dropdown --}}
                        @if(!empty($userDetails->profile_image) && file_exists(public_path('storage/' . $userDetails->profile_image)))
                            <img src="{{ asset('storage/' . $userDetails->profile_image) }}" 
                                 alt="Profile Picture" 
                                 class="profile-in-dd" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            {{-- Fallback: Default user icon --}}
                            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle me-2" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        
                        {{-- User details section --}}
                        <div class="ms-2">
                            <p class="mb-0">{{ $userDetails->name }}</p>
                            <small class="text-muted">
                                <small>Emp. Code: {{ $userDetails->employeeID }}</small>
                            </small>
                    </div>
                    </div>
                    <hr class="my-2"/>                         
                    <div class="profile-links">
                    <p class="mb-0 py-1 px-2 " onclick="openModall()" >   
                    <x-icon name="camera" />&nbsp; <small> Change Avatar  </small> 
                    </p> 
                    <p class="mb-0 py-1 px-2"> <x-icon name="lock" class="text-muted" />&nbsp; <small> Change Password </small> </p>                 
                    <hr class="my-2" /> 
                    <form action="{{ route('user.logout') }}" method="POST" >@csrf
                        <button type="submit" class="logout-icon">
                        <x-icon name="logout" /> <small> Logout </small> 
                        </button>
                     </form>

                    </div>
                </div>
            </div>  
        </div>
    </header>
     <!-- Modal -->
     <div id="myModall" class="modall">
    <form id="profile-upload-form" action="{{ route('user.uploadProfilePhoto') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content8">
            <span class="close1" onclick="closeModall()">&times;</span>
            <h2>Upload your image</h2>

            <!-- Image Container with Camera Icon -->
            <div class="image-container8" onclick="document.getElementById('fileInput').click();">
                <img id="imagePreview" class="image-preview" 
                     src="/storage/user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg" 
                     alt="User Profile Image" />
                <i class="camera-ico fas fa-camera"></i>  <!-- Camera Icon -->
            </div>

            <!-- Hidden File Input -->
            <input type="file" id="fileInput" name="profile_image" accept="image/*" onchange="previewImage()" class="d-none"/>

            <button class="buttonn" id="uploadButton" onclick="uploadImage()">Upload</button>
        </div>
    </form>
</div>  


    @yield('content')

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

        


        });

        
                    // Open the modal
function openModall() {
    document.getElementById("myModall").style.display = "block";
}

// Close the modal
function closeModall() {
    document.getElementById("myModall").style.display = "none";
}

// Preview the selected image
function previewImage() {
    const file = document.getElementById("fileInput").files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        document.getElementById("imagePreview").src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Upload the image (you can add actual upload logic here)
// function uploadImage() {
//     alert('Image uploaded successfully!');
//     closeModal();
// }
    </script>
    <script>
        // toggle notification dropdown and close on outside click
        (function(){
            var icon = document.getElementById('notificationIcon');
            var dd = document.getElementById('notificationDropdown');
            if(icon && dd){
                icon.addEventListener('click', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    dd.style.display = (dd.style.display === 'block') ? 'none' : 'block';
                });
                document.addEventListener('click', function(){
                    dd.style.display = 'none';
                });
            }
        })();
    </script>
    
    <!-- Global footer included for all pages extending this layout -->
    @include('user_view.footer')
</body>

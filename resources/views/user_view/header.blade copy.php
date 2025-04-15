<?php 

// // dd($userData);
// echo $userData->imagelink;
// exit();

$profileimahe = session('profile_image');


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo.png') }}" type="image/png">
    <title>@isset($title){{ $title }}@else{{ 'ESS Portal' }}@endisset</title>
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">


    <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
    <style>
        /* Add your custom CSS here */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            padding: 12px 20px;
            display: block;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: max-content;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
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
        .logout-icon:hover ,  .profile-links p:hover  {
            background-color:rgb(219, 219, 219) !important;border-radius:6px
        }
        .logout-icon{border:0;background:none !important;cursor:pointer;color:black;font-size:16px; padding:3px 10px;width :100%; text-align:left; }

       
        .profile-links p{cursor:pointer;}
 
                /* Modal Styles */
.modall {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content8 {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 25%;
    text-align: center;
    position: relative;
    border-radius: 15px;
}

.close1 {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    cursor: pointer;
}

.close1:hover,
.close1:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Image Container (Circle view) */
.image-container8 {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    margin: 10px auto;
}

.image-preview {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
}

.camera-ico {
    position: absolute;
    bottom: 105px;
    right: 166px;
    font-size: 24px;
    color: black;
    /* color: white; */
    /* background: rgba(0, 0, 0, 0.5); */
    padding: 8px;
    border-radius: 50%;
}
/* Button Styles */
.buttonn {
    padding: 10px 20px;
    margin-top: 20px;
    background-color: #8A3366;
    color: white;
    border: none;
    cursor: pointer;
}

.buttonn:hover {
    background-color: #8A3366;
}
    </style>
</head>
<body>

    <script>
        var successMessage = @json(session('success'));
        var errorMessage = @json(session('error'));
    </script>
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
                <!-- {{-- <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/speedometer (1).png') }}" width="30" height="30" alt="">Orgnizations Chart</a></li> -->
                <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/logout (1).png') }}" width="30" height="30" alt="">Leave & Attendance</a></li> --}}
                <li><a href="{{ route('user.view_organisation') }}"><img src="{{ asset('user_end/images/speedometer (1).png') }}" width="30" height="30" alt="">Orgnizations Chart</a></li>
                <!-- {{-- <li><a href="{{ route('user.homepage') }}"><img src="{{ asset('user_end/images/security.png') }}" width="30" height="30" alt="">PMS</a></li> --}} -->
                <li><a href="{{ route('user.hr.policy') }}"><img src="{{ asset('user_end/images/succession.png') }}" width="30" height="30" alt="">HR Policy</a></li>
                <li><a href="{{ route('PayRollDashboard') }}"><img src="{{ asset('user_end/images/succession.png') }}" width="30" height="30" alt="">Payroll</a></li>
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
                  
                    <img src="{{ asset('storage/'.$profileimahe) }}" alt="Profile Picture" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;">
                         
                    <!-- {{-- <img src="" class="profile-pic" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;"> --}} -->
                </a>
                <div class="profile-dropdown-content"> 
                    <div style="display:flex; "> 
                    <img src="{{ asset('storage/'.$profileimahe) }}" alt="Profile Picture" 
                    style="height: 30px; width: 30px; border-radius: 50%; margin: auto 8px auto 0;  vertical-align: middle;">
                    
                    <div >
                    <p style="font-size:16px">Ankita Pansare</p>
                    <small style="color:#75778A"><small> <small> Emp. Code : ST006 </small></small></small>
                    </div>
                    </div>
                    <hr style="margin:7px 0 4px 0" /> 
                        
                    <div class="profile-links">
                 <p style="margin-bottom:4px;font-size:16px; padding : 3px 10px"  onclick="openModall()" >   
                    <i class="bi bi-camera-fill" style="vertical-align: middle; "></i> <small> Change Avatar  </small> 
                </p>
                 <!-- <p style="margin-bottom:4px;font-size:16px; padding : 3px 10px" >   <i class="bi bi-person-badge-fill" style="vertical-align: middle; "></i> <small> Update Profile  </small> </p> -->
                 <p style="margin-bottom:4px;font-size:16px; padding : 3px 10px" >   <i class="bi bi-shield-lock-fill" style="vertical-align: middle; "></i> <small> Change Password </small> </p>
                 
                    <hr style="margin:7px 0 4px 0" /> 
                    <form action="{{ route('user.logout') }}" method="POST" style="margin-bottom:4px;font-size:16px" >     @csrf
                        <button type="submit" class="logout-icon">
                        <i class="bi bi-box-arrow-right"  style="vertical-align: middle; "></i> <small> Logout </small> 
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
            <input type="file" id="fileInput" name="profile_image" accept="image/*" onchange="previewImage()" style="display: none;" />

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
</body>


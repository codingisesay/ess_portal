<?php 

// // dd($userData);
// echo $userData->imagelink;
// exit();

$profileimahe = session('profile_image');


?>
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

                /* Modal Styles */
.modal {
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

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    text-align: center;
    position: relative;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Image Container (Circle view) */
.image-container {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    margin: 10px auto;
}

.image-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Button Styles */
button {
    padding: 10px 20px;
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
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
                 

                    <img src="{{ asset('storage/'.$profileimahe) }}" alt="Profile Picture" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;">
                        
           
                    
                   
                    {{-- <img src="" class="profile-pic" style="height: 50px; width: 50px; border-radius: 50%; margin-bottom: 4px; vertical-align: middle;"> --}}
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
    <button class="camera-icon" onclick="openModal()">
        <i class="fas fa-camera" ></i>
    </button>
</div>


            </div>
        </div>
    </header>
     <!-- Modal -->
     <div id="myModal" class="modal">
        <form id="profile-upload-form" action="{{ route('user.uploadProfilePhoto') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Upload your image</h2>
            <div class="image-container">
                <img id="imagePreview" class="image-preview" src="" alt="No Image" />
            </div>
            <input type="file" id="fileInput" name="profile_image" accept="image/*" onchange="previewImage()" />
            <button id="uploadButton" onclick="uploadImage()">Upload</button>
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
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Close the modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
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


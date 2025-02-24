<!DOCTYPE html>
<html>
<head>
    <title>Organisation Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        /* login.css */
        * {  
            box-sizing: border-box;  
            margin: 0;  
            padding: 0;  
            font-family: 'poppins'; 
        }  

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 100%;
        }

        .left-container {
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .right-container {
            width: 1000px;
            /* Fixed width for better alignment */
            background-color: white;
            padding: 10rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

        }

        .logo img {
            width: 250px;
            margin-bottom: 2rem;
            margin-left: 0px;
            margin-right: 55px;
        }

        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #3d0000;
            border-radius: 10px;
            font-size: 1rem;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background: #fff;
            padding: 0 5px;
            color: #aaa;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: 1px;
            left: 10px;
            font-size: 0.75rem;
            color: #8c187d;
        }

        .signup-form input:focus {
            border-color: #8c187d;
            outline: none;
        }

        /* Style for the signup container */
        .signup-container {
            text-align: center; /* Center align content */
            margin-top: 2rem; /* Add spacing above */
        }

        .signup-text {
            font-size: 1rem;
            color: #333; /* Darker color for text */
            margin-bottom: 0.5rem;
        }

        .signup-button {
            width: 30%;
            background-color: #8c187d;
            color: white;
            padding: 0.75rem 1.5rem; /* Padding to match the button style */
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none; /* Remove underline */
            /* display: inline-block; */ /* Uncomment this line if you want inline-block behavior */
        }

        .signup-button:hover {
            background-color: #6b145e;
        }

        .login-link {
            margin-top: 1rem;
            color: #8c187d;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
            color: #6b145e;
        }

        /* Adjusting paragraph styling */
        p {
            margin: 1rem 0;
            color: #555;
            text-align: center;
            /* Center-align text for better appearance */
        }

        .password-container {
            position: relative;
            /* Position for the eye icon */
            width: calc(100% - 1.5rem);
            /* Maintain input width */
        }

        .password-container input {
            width: 100%;
            /* Ensure full width */
            padding-right: 30px;
            /* Space for the eye icon */
        }

        .eye-icon {
            position: absolute;
            /* Position the icon properly */
            right: 10px;
            /* Distance from the right */
            top: 50%;
            /* Center vertically */
            transform: translateY(-50%);
            /* Adjust for perfect centering */
            cursor: pointer;
            /* Change cursor on hover */
            font-size: 1.2rem;
            /* Size of the icon */
            color: #8c187d;
            /* Color of the icon */
        }

        .login {
            text-align: center;
            /* Center the text */
            margin-top: 1.5rem;
            /* Space above the section */
        }

        .login-text {
            color: #6b6b6b;
            /* Gray color for the text */
            font-size: 1rem;
            /* Font size */
            margin: 0;
            /* Remove default margin */
        }

        .login-button {  
            width: 30%; /* Full width to match the signup button */  
            max-width: 300px; /* Set a max width to prevent it from becoming too wide */  
            padding: 0.7rem; /* Same padding as .social-btn */  
            border: 1px solid #ccc; /* Border color to match the design */  
            border-radius: 10px; /* Same border radius */  
            font-size: 1rem; /* Same font size */  
            cursor: pointer; /* Pointer cursor */  
            display: flex; /* Flexbox for alignment */  
            align-items: center; /* Center contents vertically */  
            justify-content: center; /* Center contents horizontally */  
            margin-top: 0.5rem; /* Space above the button */  
            margin-left: 150px; /* Left margin to align as per the design */  
            background-color: white; /* Background color */  
            color: #080202; /* Text color */  
            text-decoration: none; /* Remove underline */  
            transition: background-color 0.3s, color 0.3s; /* Smooth transition */  
        }

        .login-button:hover {
            background-color: #8c187d;
            /* Background color on hover */
            color: white;
            /* Change text color on hover */
        }

        .input-group1
        {  
            position: absolute;  
            right: 20px;  
            top: 50%;  
            transform: translateY(-50%);  
            width: 18px; /* Reduced size for compact design */
            height: 18px;  
            
        }  

        /* Make the login and registration box responsive */
        .login-box,
        .registration-box {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }

        /* Ensure the image in the left column is responsive */
        img.img-fluid {
            object-fit: cover;
        }

        /* Modify the colors of input fields, labels, and buttons */
        .form-control {
            border-radius: 0.375rem;
            /* Rounded corners for inputs */
            border: 1px solid #ccc;
            /* Lighter border color */
            padding: 0.75rem 1rem;
            /* Ensures consistent padding for inputs */
        }

        /* Floating label effect */
        .form-floating input:focus+label,
        .form-floating input:not(:placeholder-shown)+label {
            top: -20px;
            font-size: 20px;
            color: rgb(0, 0, 0);
            /* Change the color when input is focused */
        }

        /* For custom color on the login and registration buttons */
        .btn-primary {
            background-color: #6b145e;
            border-color: rgb(139, 177, 218);
            padding: 0.75rem;
            /* Consistent padding for the button */
        }

        .btn-primary:hover {
            background-color: #6b145e;
            border-color: #6b145e;
        }

        /* For adjusting the "Continue with Microsoft" button */
        .btn-outline-secondary {
            border-color: #6b145e;
            color: #6b145e;
            padding: 0.75rem;
        }

        .btn-outline-secondary:hover {
            background-color: #6b145e;
            color: white;
        }

        /* Ensure everything aligns properly on mobile */
        @media (max-width: 768px) {

            .login-box,
            .registration-box {
                padding: 2rem;
            }

            .container-fluid {
                height: auto;
                /* Adjust height to fit the content on small screens */
            }

            /* Make sure the login/register form buttons are full width */
            .btn-primary,
            .btn-outline-secondary {
                width: 100%;
            }
        }

        /* For input boxes with icons */
        .form-floating .position-absolute {
            right: 15px;
            /* Ensures the icon stays at the right inside the input */
        }

        /* Consistent styles for the text and error messages */
        .text-danger {
            font-size: 12px;
            margin-top: 5px;
        }

        /* Consistent styling for links */
        a.text-decoration-none {
            color: #6b145e;
        }

        a.text-decoration-none:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-container">
            <img src="{{ asset('user_end/images/Vector 58.jpg') }}" class="img-fluid vh-100 w-100 object-fit-cover" alt="Login Image">
        </div>
        <div class="right-container">
            <div class="logo">
                <img src="path/to/your/logo.png" alt="Logo">
            </div>
            <form class="signup-form" method="POST" action="{{ route('superadmin.login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder=" " value="info@siltech.co.in" required>
                    <label for="email">Username</label>
                </div>
                <div class="form-group password-container">
                    <input type="password" id="password" name="password" placeholder=" " value="akash@1234" required>
                    <label for="password">Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility()">👁️</span>
                </div>
                @if($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <button type="submit" class="signup-button">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.querySelector('.eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                eyeIcon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>

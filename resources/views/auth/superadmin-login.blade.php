<!DOCTYPE html>
<html>
<head>
    <title>Organisation Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_login.css') }}">
</head>
<body>
    <div class="container">
        <div class="left-container">
            <img src="{{ asset('user_end/images/Vector 58.jpg') }}" class="img-fluid vh-100 w-100 object-fit-cover" alt="Login Image">
        </div>
        <div class="right-container">
            <div class="logo">
            <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="SIL Logo" class="img-fluid" width="180">
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
                    <img id="password-icon" src="{{ asset('user_end/images/hidden.png') }}" alt="Show Password" class="eye-icon" onclick="togglePasswordVisibility('password')">
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
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconImg = document.getElementById(fieldId + '-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconImg.src = "{{ asset('user_end/images/eye.png') }}"; // Open eye icon
                iconImg.alt = "Hide Password";
            } else {
                passwordField.type = 'password';
                iconImg.src = "{{ asset('user_end/images/hidden.png') }}"; // Closed eye icon
                iconImg.alt = "Show Password";
            }
        }
    </script>
</body>
</html>

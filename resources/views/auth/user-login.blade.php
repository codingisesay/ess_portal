<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Tech</title>
    <link rel="icon" href="STPLLogo butterfly.png" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('user_end/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">

</head>
<body>
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="container">
        <div class="left-container">
            <img src="{{ asset('user_end/images/Vector 58.jpg') }}" class="img-fluid vh-100 w-100 object-fit-cover" alt="Login Image">
        </div>
        <div class="right-container">

            @if(session('success'))
            <div class="alert custom-alert-success">
                <strong>{{ session('success') }}</strong> 
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                
            </div>
        @endif
        
        @if(session('error'))
        <div class="alert custom-alert-error">
            <strong> {{ session('error') }}</strong>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif
            <div class="logo">
                <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="SIL Logo" class="img-fluid" width="180">
            </div>
            <form class="signup-form" method="POST" action="{{ route('user.login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="email" id="username" placeholder=" " value="akash.tech.0394@gmail.com" oninput="this.value = this.value.toUpperCase(); validateUsername()" required>
                    <label for="username">Username</label>
                    <span class="eye-icon">
                        <img src="{{ asset('user_end/images/user.png') }}" alt="Username Icon" width="24" height="24">
                    </span>
                    <div class="text-danger small"></div>
                </div>

                <div class="form-group password-container">
                    <input type="password" name="password" id="password" placeholder=" " value="akash@1234" oninput="validatePassword()" required>
                    <label for="password">Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                        <img src="{{ asset('user_end/images/hidden.png') }}" alt="Show Password" width="24" height="24" id="password-icon">
                    </span>
                    <div class="text-danger small"></div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>

                <!-- Login Button -->
                <button type="submit" name="login" class="signup-button">Login</button>

                <!-- Forgot Password -->
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                </div>

                <!-- OR Separator -->
                <div class="text-center my-3">
                    <span class="text-muted">OR</span>
                </div>

                <!-- Microsoft Login -->
                <button type="button" class="btn btn-outline-secondary" onclick="window.location.href=''">
                    <img src="{{ asset('user_end/images/windows.png'); }}" alt="Microsoft Icon" width="18" height="18" class="me-2">
                    Continue with Microsoft
                </button>

                <!-- Register Link -->
                <!-- <div class="text-center mt-3">
                    <p class="mb-1">Don’t have an account?</p>
                    <a href="onboarding_form.php" class="btn btn-outline-secondary">Register</a>
                </div> -->
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


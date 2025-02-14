
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Tech</title>
    <link rel="icon" href="STPLLogo butterfly.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('user_end/css/login.css') }}">
</head>
<body>
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <!-- Left Side Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('user_end/images/Vector 58.jpg') }}" class="img-fluid vh-100 w-100 object-fit-cover" alt="Login Image">
            </div>

            <!-- Right Side Login Form -->
            <div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
                <div class="login-box p-4 rounded bg-white w-100">
                    <div class="text-center mb-3">
                        <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="SIL Logo" class="img-fluid" width="180">
                    </div>

                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" name="email" id="username" class="form-control" placeholder="Username" value="akash.tech.0394@gmail.com" oninput="this.value = this.value.toUpperCase(); validateUsername()" required>
                            <label for="username">Username</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                <img src="{{ asset('user_end/images/user.png') }}" alt="Username Icon" width="24" height="24">
                            </span>
                            <div class="text-danger small"></div>
                        </div>

                        <div class="form-floating mb-3 position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="akash@1234" oninput="validatePassword()" required>
                            <label for="password">Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer;" onclick="togglePasswordVisibility('password')">
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
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>

                        <!-- Forgot Password -->
                        <div class="text-center mt-3">
                            <a href="forgot_pass.php" class="text-decoration-none">Forgot Password?</a>
                        </div>

                        <!-- OR Separator -->
                        <div class="text-center my-3">
                            <span class="text-muted">OR</span>
                        </div>

                        <!-- Microsoft Login -->
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="window.location.href=''">
                            <img src="{{ asset('user_end/images/windows.png'); }}" alt="Microsoft Icon" width="18" height="18" class="me-2">
                            Continue with Microsoft
                        </button>

                        <!-- Register Link -->
                        <div class="text-center mt-3">
                            <p class="mb-1">Don’t have an account?</p>
                            <a href="onboarding_form.php" class="btn btn-outline-secondary w-100">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconImg = document.getElementById(fieldId + '-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconImg.src = "image/eye.png"; // Open eye icon
                iconImg.alt = "Hide Password";
            } else {
                passwordField.type = 'password';
                iconImg.src = "image/hidden.png"; // Closed eye icon
                iconImg.alt = "Show Password";
            }
        }
    </script>
</body>
</html>


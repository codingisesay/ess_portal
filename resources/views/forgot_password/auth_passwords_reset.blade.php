{{-- <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div>
        <label for="password">New Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <button type="submit">Reset Password</button>
</form> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Tech - Register</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}"  />
    <link rel="stylesheet" href="{{ asset('user_end/css/forgot_password.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
</head>

<body>
    <div class="container">
        <div class="left-container">
            <img src="{{ asset('user_end/images/Vector 58.jpg') }}" alt="Register Image">
        </div>
        <div class="right-container">

            {{-- <div class="alert custom-alert-success">
        <strong>Success! This alert box could indicate a successful or positive action.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    
    <div class="alert custom-alert-error">
        <strong>Error! Something went wrong. Please try again later.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div> --}}
    
    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif
            <div class="logo">
                <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="SIL Logo">
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder=" " oninput="validatePassword()" required>
                    <label for="password">New Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                        <img src="{{ asset('user_end/images/hidden.png') }}" alt="Show Password" width="24" height="24" id="password-icon">
                    </span>
                    <div class="text-danger small"></div>
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" id="repeat_password" placeholder=" " required>
                    <label for="repeat_password">Confirm Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('repeat_password')">
                        <img src="{{ asset('user_end/images/hidden.png') }}" alt="Show Password" width="24" height="24" id="repeat_password-icon">
                    </span>
                    <div class="text-danger small"></div>
                </div>

                

                <button type="submit" name="register" class="signup-button">Reset Password</button>

               
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconImg = document.getElementById(fieldId + '-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconImg.src = "/user_end/images/eye.png"; // Open eye icon
                iconImg.alt = "Hide Password";
            } else {
                passwordField.type = 'password';
                iconImg.src = "/user_end/images/hidden.png"; // Closed eye icon
                iconImg.alt = "Show Password";
            }
        }
    </script>
</body>

</html>
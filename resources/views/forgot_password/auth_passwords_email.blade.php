{{-- <form action="{{ route('password.email') }}" method="POST">
    @csrf
    <input type="email" name="email">
    <button type="submit">Submit</button>
</form> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Tech</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />

    <!-- Bootstrap CSS -->
   

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('user_end/css/forgot_password.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
</head>
<body>
    <div class="container">
        <div class="left-container">
            <img src="{{ asset('user_end/images/Vector 58.jpg') }}" alt="Login Image">
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

        @if($errors->any())
        <div class="alert custom-alert-warning">
<ul>
    @foreach($errors->all() as $error)
        <li style="color: red;">{{ $error }}</li>
        
    @endforeach
</ul>
        </div>
@endif
            
            
            {{-- <div class="alert custom-alert-success">
        <strong>Success! This alert box could indicate a successful or positive action.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    
    <div class="alert custom-alert-error">
        <strong>Error! Something went wrong. Please try again later.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    
    <div class="alert custom-alert-warning">
        <strong>Warning! Be cautious when making changes. Please double-check your input.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div> --}}
            <div class="logo">
                <img src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="SIL Logo">
            </div>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" id="username" placeholder=" " oninput="this.value = this.value.toUpperCase(); validateUsername()" required>
                    <label for="username">Email ID</label>
                    <span class="eye-icon">
                        <img src="{{ asset('user_end/images/user.png') }}" alt="Username Icon" width="24" height="24">
                    </span>
                    <div class="text-danger small"></div>
                </div>
                
                
                <button type="submit" name="submit" class="signup-button">Submit</button>
               
            </form>
        </div>
    </div>

    
</body>
</html>

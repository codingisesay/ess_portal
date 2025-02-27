<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <p>Click the link below to reset your password:</p>
    <a href="{{$data['reset_password_link']}}">Reset Password</a>
    {{-- <p><strong>Your Email:</strong>{{$data['reset_password_link']}} </p> --}}
    
</body>
</html>

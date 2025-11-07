<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <p>Dear <b>{{$data['name']}}</b>,</p>
    <p>Welcome to <b>EmployeeXpert</b>, your HRMS portal for managing attendance, leaves, payroll, and more.</p>
    <ul>
        <li><p><strong>Your Email:</strong> {{ $data['username'] }}</p></li>
        <li><p><strong>Your Password:</strong> {{ $data['password'] }}</p></li>
        <li><p><strong>Login URL:</strong> <a href="http://13.60.206.138/">Click Me!!</a></p></li>
    </ul>
    
    {{-- <p><strong>Your Password:</strong> {{ $data['password'] }}</p> --}}
    {{-- Updated contact email from info@siltech.co.in to info@payvance.co.in on 2025-11-06 --}}
    <p>Please log in and update your profile at your earliest convenience. For any assistance, contact <b>info@payvance.co.in</b>.</p>
</body>
</html>

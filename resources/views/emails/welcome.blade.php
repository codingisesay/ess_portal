<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <h1>Welcome to Our Platform</h1>
    <p>Your registration was successful!</p>
    <p><strong>Your Email:</strong> {{ $data['username'] }}</p>
    <p><strong>Your Password:</strong> {{ $data['password'] }}</p>
    <p>Please make sure to change your password after logging in.</p>
</body>
</html>

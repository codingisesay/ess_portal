<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <?php 
                        $startDateString = $data['start_date'];  // Your input date string
                        $starttimestamp = strtotime($startDateString);  // Convert the date string to a timestamp
                        $startformattedDate = date('d/m/Y', $starttimestamp);  // Format as "date:month:year"

                        
                        $endDateString = $data['end_date'];  // Your input date string
                        $endtimestamp = strtotime($endDateString);  // Convert the date string to a timestamp
                        $endformattedDate = date('d/m/Y', $endtimestamp);  // Format as "date:month:year"
        
        
        ?>

<p>Dear <b>{{ $data['name'] }},</b></p>
 
<p>Your leave request for <b>{{ $data['leave_type'] }}</b> from <b>{{ $startformattedDate }}</b> to <b>{{ $endformattedDate }}</b> has been submitted successfully in EmployeeXpert.</p>
 
<p>You will be notified once your leave is approved or rejected.</p>
 


<address>
    <b>Best regards,</b><br>
<b>EmployeeXpert Team</b><br>
    </address>

    {{-- <h1>Welcome to Our Platform</h1>
    <p>Your registration was successful!</p>
    <p><strong>Your Email:</strong> {{ $data['username'] }}</p>
    <p><strong>Your Password:</strong> {{ $data['password'] }}</p>
    <p>Please make sure to change your password after logging in.</p> --}}
</body>
</html>

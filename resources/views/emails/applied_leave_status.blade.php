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

<?php 
if($data['leave_status'] == "Approved"){?>

<p>Your leave request for <b>{{ $data['leave_type'] }}</b> from <b>{{ $startformattedDate }}</b> to <b>{{ $endformattedDate }}</b> has been <b>approved</b> by <b>{{$data['approved_by']}}</b>.</p>
 
<p>Enjoy your leave!</p>

<?php

}elseif($data['leave_status'] == "Reject"){?>

<p>Your leave request for <b>{{ $data['leave_type'] }}</b> from <b>{{ $startformattedDate }}</b> to <b>{{ $endformattedDate }}</b> has been <b>rejected</b> by <b>{{$data['approved_by']}}</b>.</p>
 
<p>For further clarification, please reach out to your manager.</p>

<?php

}elseif($data['leave_status'] == "Cancelled"){?>

<p>Your leave request for <b>{{ $data['leave_type'] }}</b> from <b>{{ $startformattedDate }}</b> to <b>{{ $endformattedDate }}</b> has been <b>Cancelled</b> by <b>Yourself</b>.</p>


<?php

}


?>

<address>
    <b>Best regards,</b><br>
<b>EmployeeXpert Team</b><br>
    </address>

</body>
</html>

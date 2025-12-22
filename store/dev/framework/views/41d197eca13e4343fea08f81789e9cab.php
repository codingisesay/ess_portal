<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($subject); ?></title>
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

<p>Dear <b><?php echo e($data['managername']); ?>,</b></p>
 
<p><b><?php echo e($data['employeename']); ?>,</b> leave request for <b><?php echo e($data['leave_type']); ?></b> from <b><?php echo e($startformattedDate); ?></b> to <b><?php echo e($endformattedDate); ?></b> has been submitted successfully in EmployeeXpert.</p>
 
<p>You are requested to check the same and approve/reject.</p>
 


<address>
    <b>Best regards,</b><br>
<b>EmployeeXpert Team</b><br>
    </address>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/emails/applied_leave_mail.blade.php ENDPATH**/ ?>
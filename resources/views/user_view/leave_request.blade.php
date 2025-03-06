
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Form</title>
    <link rel="stylesheet" href="{{asset('user_end/css/leave_request.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
      function confirmCancel() {
            const cancelConfirmation = confirm("Do you really want to cancel?");
            if (cancelConfirmation) {
                window.location.href = "{{route('leave_dashboard')}}"; // Replace with the actual URL for your dashboard
            }
        }
    </script>
</head>
<?php 
error_reporting(0);
// dd($loginUserInfo);

?>
<body>
    <div style="margin-top: 200px;">
<form action="leave_request_app.php" method="POST" id="leave_form">
    <div class="close-btn" onclick="confirmCancel()">&#10005;</div>
    <h1>Leave Request Form</h1>
        
    <label for="employee_no">Employee No:</label>
    <input type="text" id="employee_no" name="employee_no" value="{{ $loginUserInfo->employeeID }}" readonly>
    <br>

    <label for="employee_name">Employee Name:</label>
    <input type="text" id="employee_name" name="employee_name" value="{{ $loginUserInfo->name }}" readonly>
    <br>

    <label for="leave_type">Leave Type:</label>
    <select name="leave_type" id="leave_type" required>
        <option value="" disabled selected>Select Leave Type</option>
        @foreach ($datas as $data)
        <option value="{{ $data->leave_type_id }}">{{ $data->leave_type }}</option> 
        @endforeach
    </select>
    <br>

    <label for="remaining_days">Available Days:</label>
    <input type="number" id="remaining_days" name="remaining_days" readonly>
    <br>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required min="2023-01-01">
    <br>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required min="2023-01-01">
    <br>
<div id="display_half_day" style="display:none;">
    <label for="leave_slot">Slot:</label>
    <select name="leave_slot" id="leave_slot" required>
        <option value="" disabled selected>Select An Option</option>
        <option value="">Full Day</option>
        <option value="">First Half</option>
        <option value="">Second Half</option>
       
    </select>
</div>
<br>
    <label for="reason">Reason:</label>
    <textarea id="reason" name="reason" required></textarea>
    <br>

    <button type="button" class="submit-btn" onclick="showConfirmationMessageBox()">Submit Leave Request</button>
</form>
    </div>
<div id="customAlert" class="custom-alert">
    <div class="alert-box">
        <p id="alertMessage"></p>
        <button onclick="confirmAction()">OK</button>
        <button class="cancel" onclick="cancelAction()">Cancel</button>
    </div>
</div>

<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">x</span>
        <h3>Leave Request Confirmation</h3>
        <p id="confirmationMessage"></p>
        <button class="btn" onclick="submitForm()">Submit</button>
        <button class="btn cancel" onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>

$(document).ready(function () {
    //For load leave according to the leave policy and taken leaves
            $('#leave_type').on('change',function () {
                // Create data to send with the request
             var leave_id = $(this).val();

            
                     // Perform the AJAX request
                $.ajax({
                  
                    url:'/user/remaning_leave/' + leave_id, // Send leave_id in the URL
                    type: 'get',
                    success: function (response) {
                        // Handle success
                        $('#remaining_days').val(response.remaining_leave);
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        $('#response').html('Error: ' + error);
                    },
                    dataType: 'json', // Expect a JSON response
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


        
            });


            //load data for selecting half days according to the same date and leave policy

            $('#end_date').on('change',function () {
                // Create data to send with the request
             var start_date = $('#start_date').val();
             var end_date = $(this).val();
             var leave_id = $('#leave_type').val();

            
        // console.log(leave_id);
        // console.log(start_date);
        // console.log(end_date);
         // Construct the URL with the parameters
         var url = '/user/half_days_status/' + leave_id + '/' + start_date + '/' + end_date;

                     // Perform the AJAX request
                     $.ajax({
                  
                  url: url,
                  type: 'get',
                  success: function (response) {
                      // Handle success
                     $('#display_half_day').css({
                        display:response.half_day_status
                     })
                    // console.log(response);
                  },
                  error: function (xhr, status, error) {
                      // Handle error
                      $('#response').html('Error: ' + error);
                  },
                  dataType: 'json', // Expect a JSON response
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });


        
            });

        });


    function fetchEntitledDays() {
        // Simulate fetching entitled days
        const leaveType = document.getElementById("leave_type").value;
        const remainingDays = leaveType === "Annual Leave" ? 10 : 5;
        document.getElementById("remaining_days").value = remainingDays;
    }

    document.getElementById("start_date").addEventListener("change", validateDates);
    document.getElementById("end_date").addEventListener("change", validateDates);

    function validateDates() {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if (startDate && endDate) {
            if (new Date(endDate) < new Date(startDate)) {
                alert("End date cannot be earlier than the start date.");
                document.getElementById("end_date").value = "";
            }
        }
    }

    function showAlert(message) {
        document.getElementById("alertMessage").textContent = message;
        document.getElementById("customAlert").style.display = "flex";
    }

    function confirmAction() {
        closeAlert();
    }

    function cancelAction() {
        closeAlert();
    }

    function closeAlert() {
        document.getElementById("customAlert").style.display = "none";
    }

    function showConfirmationMessageBox() {
        var employeeNo = document.getElementById("employee_no").value;
        var employeeName = document.getElementById("employee_name").value;
        var leaveType = document.getElementById("leave_type").value;
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;
        var reason = document.getElementById("reason").value;

        function formatDate(dateStr) {
            var date = new Date(dateStr);
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        if (!employeeNo || !employeeName || !leaveType || !startDate || !endDate || !reason) {
            alert("All fields must be filled out!");
            return false;
        }

        var formattedStartDate = formatDate(startDate);
        var formattedEndDate = formatDate(endDate);

        var today = new Date();
        var formattedToday = formatDate(today.toISOString().split('T')[0]);

        var status = "PENDING";

        var confirmationMessage = 
            "<div class='field'><span class='label'>Employee No:</span> <span class='value'>" + employeeNo + "</span></div>" +
            "<div class='field'><span class='label'>Employee Name:</span> <span class='value'>" + employeeName + "</span></div>" +
            "<div class='field'><span class='label'>Leave Type:</span> <span class='value'>" + leaveType + "</span></div>" +
            "<div class='field'><span class='label'>Start Date:</span> <span class='value'>" + formattedStartDate + "</span></div>" +
            "<div class='field'><span class='label'>End Date:</span> <span class='value'>" + formattedEndDate + "</span></div>" +
            "<div class='field'><span class='label'>Reason:</span> <span class='value'>" + reason + "</span></div>" +
            "<div class='field'><span class='label'>Request Date:</span> <span class='value'>" + formattedToday + "</span></div>" +
            "<div class='field'><span class='label'>Status:</span> <span class='value'>" + status + "</span></div>";

        document.getElementById("confirmationMessage").innerHTML = confirmationMessage;
        document.getElementById("confirmationModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("confirmationModal").style.display = "none";
    }

    function submitForm() {
        closeModal();
        document.getElementById("leave_form").submit();
    }
</script>

</body>
</html>

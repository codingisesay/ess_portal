
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Form</title> 
    <!-- <link rel="stylesheet" href="{{asset('user_end/css/leave_request.css')}}"> -->
    
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      function confirmCancel() { 
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to cancel and leave the page?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, leave',
                    cancelButtonText: 'No, stay'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user confirms, redirect to the dashboard
                        window.location.href = "{{route('leave_dashboard')}}"; // Replace with the actual URL for your dashboard
                    }
                });
            } 
    </script>
</head>
<?php 
error_reporting(0);
// dd($loginUserInfo);

?>
<body>
    <div class="modal d-block" >
        <div class="modal-content">
            <div class="close" onclick="confirmCancel()">×</div>
            <h5>Leave Request Form</h5>  
            <form action="{{ route('insert_leave') }}" method="POST" id="leave_form" class="row">
                @csrf
                <div class="col-md-6 my-2">             
                    <div class="floating-label-wrapper">
                        <input type="text" class="input-field" id="employee_no" name="employee_no" value="{{ $loginUserInfo->employeeID }}"  readonly >
                        <label for="employee_no">Employee No</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <input type="text" class="input-field" id="employee_name" name="employee_name" value="{{ $loginUserInfo->name }}" readonly >
                        <label for="employee_name">Employee Name</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper"> 
                        <select class="input-field" name="leave_type" id="leave_type" required>
                            <option value="" disabled selected>Select Leave Type</option>
                            @foreach ($datas as $data)
                            <option value="{{ $data->leave_type_id }}">{{ $data->leave_type }}</option> 
                            @endforeach
                        </select>
                        <label for="leave_type">Leave Type</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <input  class="input-field"  type="number" id="remaining_days" name="remaining_days" readonly disabled placeholder="00">
                        <label for="remaining_days">Available Days</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <input class="input-field"  type="date" id="start_date" name="start_date" required min="2023-01-01">
                        <label for="start_date">Start Date</label>
                    </div>
                </div> 
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <input class="input-field"  type="date" id="end_date" name="end_date" required min="2023-01-01">
                        <label for="end_date">End Date</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <textarea id="reason" name="reason" class="input-field" maxlenght="150" placeholder="Reason in brief.." required></textarea>
                        <label for="reason">Reason</label>
                    </div>
                </div>
                <div class="col-md-6 my-2">
                    <div class="floating-label-wrapper">
                        <select class="input-field" name="leave_slot" id="leave_slot" >
                            <option value="">Select An Option</option>
                            <option value="Full Day">Full Day</option>
                            <option value="First Half">First Half</option>
                            <option value="Second Half">Second Half</option> 
                        </select>
                        <label for="leave_slot">Slot</label>
                    </div>
                </div>
         
                <div class='col-12 text-right'>
                    <button type="submit" class="submit-btn px-4 py-2">Submit Leave Request</button>
                </div>
            </form>
        </div>
    </div>
<div id="customAlert" class="custom-alert">
    <div class="alert-box">
        <p id="alertMessage"></p>
        <button onclick="confirmAction()">OK</button>
        <button class="cancel" onclick="cancelAction()">Cancel</button>
    </div>
</div>

<!-- {{-- <div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">x</span>
        <h3>Leave Request Confirmation</h3>
        <p id="confirmationMessage"></p>
        <button class="btn" onclick="submitForm()">Submit</button>
        <button class="btn cancel" onclick="closeModal()">Cancel</button>
    </div>
</div> --}} -->

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


</script>

</body>
</html>

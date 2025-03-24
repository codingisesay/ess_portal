@include('user_view.header')
@extends('user_view/edit_user/employee_form_layout') <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
{{-- @if(session('success'))
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
@endif --}}

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif

<div class="tab-content active" id="tab6">
    <form id="employmentForm" action="{{route('edit_preEmp_insert')}}" method="POST">
        @csrf
        <input type="hidden" name="form_step8" value="employment_step">
        <h3>Previous Employment</h3>
        <button type="button" class="add-row-employment action-button" onclick="addEmploymentRow()">Add Previous
            Employment</button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <!-- <th>Company Name</th> -->
                        <th>Employer Name</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Designation</th>
                        <th>Last Drawn Annual Salary</th>
                        <th>Relevant Experience</th>
                        <th>Reason For Leaving</th>
                        <th>Major Responsibilities Held</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="employmentTableBody">
                    <!-- Rows will be added dynamically here -->
                    @foreach($emp_preEmp_details as $index => $detail)
                    <tr>
                        <td class="serial-number">{{ $index + 1 }}</td>
 
<td>
    <input type="hidden" name="serial_no[]" value="${employmentCounter}">
    <input type="custom-employer" name="employer_name[]" placeholder="Enter Employer Name" value="{{$detail->employer_name}}" required  maxlength="250"  oninput="this.value.replace(/[^a-zA-Z .,(){}[\]]/g, '').();">
</td>
<td>
<select name="country[]" class="country-type" id="country">
<option value="{{$detail->country}}">{{$detail->country}}</option>
@foreach($countrys as $col)

<option value="{{$col->name}}">{{$col->name}}</option>

@endforeach
</select>
</td>
<td><input type="text" name="city[]" class="custom-city" placeholder="Enter City" required  maxlength="25"  onkeydown="return blockNumbers(event);"
 oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').();" value="{{$detail->city}}"></td>
<td><input type="date" name="from_date[]" required max="<?php echo date('Y-m-d'); ?>" onblur="calculateExperience(this)" value="{{$detail->from_date}}"></td>
<td><input type="date" name="to_date[]" required max="<?php echo date('Y-m-d'); ?>" onblur="calculateExperience(this)" value="{{$detail->to_date}}"></td>
<td><input type="custom-designation" name="designation[]" placeholder="Enter Designation"  maxlength="50" required oninput="this.value = this.value.()" value="{{$detail->designation}}"></td>
<td>
<input type="text" name="last_drawn_salary[]" 
   placeholder="Enter Last Drawn Annual Salary" 
   required 
   class="custom-salary"
   oninput="limitSalaryInput(this); alignSalary(this)" 
   onblur="formatSalary(this)" 
   style="text-align: right;" value="{{$detail->last_drawn_annual_salary}}">
</td>

<td><input type="custom-experience" name="relevant_experience[]" placeholder="Enter Relevant Experience" required
 readonly value="{{$detail->relevant_experience}}"></td>

<td><input type="custom-reason" name="reason_for_leaving[]" placeholder="Enter Reason For Leaving"  maxlength="250" value="{{$detail->reason_for_leaving}}" required></td>
<td><input type="custom-major" name="major_responsibilities[]" placeholder="Enter Major Responsibilities"  maxlength="2000" required value="{{$detail->major_responsibilities}}"></td>
{{-- <td><button type="button" onclick="editEmploymentRow(this)">✏️</button></td> --}}
<td><button class="delete-button" data-id="{{ $detail->id }}" type="button" >❌</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- <div class="button-container">
            <button class="previous-btn" type="button">Previous</button>
            <button type="submit" class="next-btn">Next</button>
        </div> -->
        <div class="button-container">
            <a href="{{ route('user.family') }}" style="text-decoration:none;">
                <button type="button" class="previous-btn">
                    <span>&#8249;</span>
                </button>
            </a>
            <button type="submit" class="next-btn">
                <span>&#8250;</span>
            </button>
        </div>

    </form>
</div>
<!-- uppercase bug -->
<!-- JavaScript to Handle Adding Employment Rows Dynamically -->
<script>
    let employmentCounter = 1; // Counter for row serial numbers

    // Function to dynamically add a row
    function addEmploymentRow() {
        const tableBody = document.getElementById('employmentTableBody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
<td class="serial-number">${employmentCounter}</td>
 
<td>
    <input type="hidden" name="serial_no[]" value="${employmentCounter}">
    <input type="custom-employer" name="employer_name[]" placeholder="Enter Employer Name" required  maxlength="250"  oninput="this.value.replace(/[^a-zA-Z .,(){}[\]]/g, '').();">
</td>
<td>
<select name="country[]" class="country-type" id="country">
<option value="">Select Country</option>
@foreach($countrys as $col)
<option value="{{$col->name}}">{{$col->name}}</option>
@endforeach
</select>
</td>



<td><input type="text" name="city[]" class="custom-city" placeholder="Enter City" required  maxlength="25"  onkeydown="return blockNumbers(event);"
 oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').();"></td>
<td><input type="date" name="from_date[]" required max="<?php echo date('Y-m-d'); ?>" onblur="calculateExperience(this)"></td>
<td><input type="date" name="to_date[]" required max="<?php echo date('Y-m-d'); ?>" onblur="calculateExperience(this)"></td>
<td><input type="custom-designation" name="designation[]" placeholder="Enter Designation"  maxlength="50" required oninput="this.value = this.value.()"></td>
<td>
<input type="text" name="last_drawn_salary[]" 
   placeholder="Enter Last Drawn Annual Salary" 
   required 
   class="custom-salary"
   oninput="limitSalaryInput(this); alignSalary(this)" 
   onblur="formatSalary(this)" 
   style="text-align: right;">
</td>

<td><input type="custom-experience" name="relevant_experience[]" placeholder="Enter Relevant Experience" required
 readonly></td>

<td><input type="custom-reason" name="reason_for_leaving[]" placeholder="Enter Reason For Leaving"  maxlength="250" required></td>
<td><input type="custom-major" name="major_responsibilities[]" placeholder="Enter Major Responsibilities"  maxlength="2000" required></td>

<td><button type="button" onclick="removeEmploymentRow(this)">❌</button></td>
`;

        tableBody.appendChild(newRow);
        employmentCounter++; // Increment the counter for the next row's Serial No
    }

    // Function to remove a row
    function removeEmploymentRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateEmploymentSerialNumbers();
    }

    // Function to reassign serial numbers dynamically after row removal
    function updateEmploymentSerialNumbers() {
        const rows = document.querySelectorAll('#employmentTableBody tr');
        let index = 1;
        rows.forEach(row => {
            row.querySelector('.serial-number').innerText = index;
            row.querySelector('input[name="serial_no[]"]').value = index; // Update hidden fields with correct serial number
            index++;
        });
        employmentCounter = index;
    }

    // Function to toggle edit mode for a specific row
    function editEmploymentRow(button) {
        const row = button.closest('tr');
        const inputs = row.querySelectorAll('input');

        if (button.innerText === "✏️") {
            inputs.forEach(input => {
                input.removeAttribute('readonly');
            });
            button.innerText = "💾";
        } else {
            inputs.forEach(input => {
                input.setAttribute('readonly', true);
            });
            button.innerText = "✏️";
        }
    }
</script>
<script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>
<script>
    $(document).on('click', '.delete-button', function () {
        // Get the ID of the record to be deleted
        var preEmolyee = $(this).data('id');
      
    console.log(preEmolyee);
        // Confirm delete action
        if (confirm('Are you sure you want to delete this item?')) {
            // Send an AJAX DELETE request to the server
            $.ajax({
                url: '/user/pre_emply/' + preEmolyee,  // Adjust the route URL if necessary
                type: 'DELETE',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}', 
                    preEmolyee:preEmolyee,// CSRF token for security
                },
                success: function (response) {
                    // On success, remove the row from the table
                    $('button[data-id="' + preEmolyee + '"]').closest('tr').remove();
                    alert('Education record deleted successfully!');
                },
                error: function (response) {
                    alert('Error deleting record. Please try again.');
                    console.log(preEmolyee);
                }
            });
        }
    });
    document.getElementById('previous-btn-link').addEventListener('click', function(event) {
        event.stopPropagation(); // Stop the form submission from being triggered
    });

    </script>

@endsection
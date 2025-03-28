@include('user_view.header')
@extends('user_view/edit_user/employee_form_layout')  <!-- Extending the layout file -->
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

<?php 

$permission_array = session('id');
?>

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif
<div class="tab-content active" id="tab5">
    <form id="familyForm" action="{{route('edit_family_insert')}}" method="POST">
        <!-- <input type="hidden" name="employeeNo" value="P111"> -->
       @csrf
        <input type="hidden" name="form_step7" value="family_step">
        <h3>Family Details</h3>
        <button type="button" class="add-row-family action-button" onclick="addFamilyRow()">Add Family
            Information</button>

        <div class="table-container-family">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Name</th>
                            <th>Relation</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Dependent</th>
                            <th>Phone Number</th>
                            {{-- <th>Edit</th> --}}
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="familyTableBody">
                        <!-- Rows will be added dynamically here -->
                        @foreach($familyDetails as $index => $detail)
                        <tr>
                            <td>{{$index +1 }}</td> <!-- Display serial number in the table -->
                            <td>
                                <input type="hidden" name="serial_no[]" value="${familyCounter}">
                                <input type="text" name="name[]" class="custom-name" placeholder="Enter Name" value="{{$detail->name}}" required maxlength="50"
                                   oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '').();"  onkeydown="return blockNumbers(event);">
                            </td>
                            <td>
                                <select name="relation[]" class="relation-type dropdown" required>
                                    <option value="{{$detail->relation}}">{{$detail->relation}}</option>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Child">Child</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Sibiling">Sibling</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                            <td>
                                <input type="date" name="birth_date[]" required value="{{$detail->birth_date}}" onchange="calculateAge(this)" 
                                    max="<?php echo date('Y-m-d'); ?>">
                            </td>
                            <td>
                                <select name="gender[]" class="gender-type dropdown" required>
                                    <option value="{{$detail->gender}}">{{$detail->gender}}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                            <td><input type="custom-age" name="age[]" value="{{$detail->age}}" placeholder="Age" required readonly></td>
                            <td>
                                <select name="dependent[]" class="dependent-type dropdown" required>
                                    <option value="{{$detail->dependent}}" >{{$detail->dependent}}</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td><input type="tel" name="phone_number[]" placeholder="Phone Number" value="{{$detail->phone_number}}"  maxlength="10" inputmode="numeric" 
                            title="Please enter a 10-digit phone number" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
                            {{-- <td><button type="button" onclick="editFamilyRow(this)">✏️</button></td> --}}
                            <td><button type="button" class="delete-button" data-id="{{ $detail->id }}">❌</button></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="button-container">
            <button class="previous-btn" type="button">Previous</button>
            <button type="submit" class="next-btn">Next</button>
        </div> -->
        <div class="button-container">
            <a href="{{ route('user.editbank',['id' => $permission_array]) }}" style="text-decoration:none;">
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
<script>
     let familyCounter = @json(count($familyDetails)) + 1;
    // let familyCounter = 1; // Auto-incrementing counter for Family Details
    function addFamilyRow() {
        const tableBody = document.getElementById('familyTableBody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
<td>${familyCounter}</td> <!-- Display serial number in the table -->
<td>
    <input type="hidden" name="serial_no[]" value="${familyCounter}">
    <input type="text" name="name[]" class="custom-name" placeholder="Enter Name" required maxlength="50"
       oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '').();"  onkeydown="return blockNumbers(event);">
</td>
<td>
    <select name="relation[]" class="relation-type" required>
        <option value="" disabled selected>Select Relation</option>
        <option value="Spouse">Spouse</option>
        <option value="Child">Child</option>
        <option value="Parent">Parent</option>
        <option value="Sibiling">Sibling</option>
        <option value="Other">Other</option>
    </select>
</td>
<td>
    <input type="date" name="birth_date[]" required onchange="calculateAge(this)" 
        max="<?php echo date('Y-m-d'); ?>">
</td>
<td>
    <select name="gender[]" class="gender-type" required>
        <option value="" disabled selected>Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>
</td>
<td><input type="custom-age" name="age[]" placeholder="Age" required readonly></td>
<td>
    <select name="dependent[]" class="dependent-type" required>
        <option value="" disabled selected>Select</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</td>
<td><input type="tel" name="phone_number[]" placeholder="Phone Number"  maxlength="10"  inputmode="numeric" 
title="Please enter a 10-digit phone number" 
oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
<td><button type="button" onclick="removeFamilyRow(this)">❌</button></td>
`;

        tableBody.appendChild(newRow);

        familyCounter++; // Increment the serial counter

        // Add event listeners to the new row
        newRow.querySelectorAll('input[name="name[]"]').forEach(input => {
            input.addEventListener('keypress', restrictNumbers);
        });
    }

    let educationCounter = @json(count($familyDetails)) + 1;

    // Function to remove rows
    function removeFamilyRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateFamilySerialNumbers(); // Update serial numbers after row removal
    }

    // Update serial numbers after row deletion
    function updateFamilySerialNumbers() {
        const rows = document.querySelectorAll('#familyTableBody tr');
        let counter = 1;
        rows.forEach((row) => {
            row.querySelector('td:first-child').innerText = counter; // Update visible serial number
            row.querySelector('input[name="serial_no[]"]').value = counter; // Update hidden serial number
            counter++;
        });
        familyCounter = counter; // Reset counter to the next number
    }

    function calculateAge(birthDateInput) {
        const birthDate = new Date(birthDateInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        const ageInput = birthDateInput.closest('tr').querySelector('input[name="age[]"]');
        ageInput.value = age;
    }

    function editFamilyRow(button) {
        const row = button.closest('tr');
        // Add your edit logic here (toggle between edit/view mode)
    }

    // Function to restrict numbers in text fields
    function restrictNumbers(event) {
        const keyCode = event.which ? event.which : event.keyCode;
        if (keyCode >= 48 && keyCode <= 57) {
            event.preventDefault();
        }
    }

    // Add event listeners to name fields
    document.querySelectorAll('input[name="name[]"]').forEach(input => {
        input.addEventListener('keypress', restrictNumbers);
    });
</script>
{{-- <script src="{{ asset('user_end/js/onboarding_form.js') }}"></script> --}}
<script>
    $(document).on('click', '.delete-button', function () {
        // Get the ID of the record to be deleted
        var familyId = $(this).data('id');
      
    console.log(familyId);
        // Confirm delete action
        if (confirm('Are you sure you want to delete this item?')) {
            // Send an AJAX DELETE request to the server
            $.ajax({
                url: '/user/del_family/' + familyId,  // Adjust the route URL if necessary
                type: 'DELETE',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}', 
                    familyId:familyId,// CSRF token for security
                },
                success: function (response) {
                    // On success, remove the row from the table
                    $('button[data-id="' + familyId + '"]').closest('tr').remove();
                    alert('Education record deleted successfully!');
                },
                error: function (response) {
                    alert('Error deleting record. Please try again.');
                    console.log(familyId);
                }
            });
        }
    });
    document.getElementById('previous-btn-link').addEventListener('click', function(event) {
        event.stopPropagation(); // Stop the form submission from being triggered
    });

    </script>
       <script>
        window.onload = function () {
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const selectedValue = dropdown.value;

        for (let option of dropdown.options) {
            if (option.value === selectedValue) {
                option.style.display = 'none';
                break;
            }
        }
    });
};
    </script>

@endsection
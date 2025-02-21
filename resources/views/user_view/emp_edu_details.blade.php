@extends('user_view/employee_form_layout') <!-- Extending the layout file -->
@section('content') <!-- Defining the content section -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
        <li style="color: red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<div class="w3-container">

    @if(session('success'))
    <div class="w3-panel w3-green">
        {{ session('success') }} 
    </div>
    @endif

    @if(session('error'))
    <div class="w3-panel w3-red">
        {{ session('error') }} 
    </div>
    @endif

</div>

<div class="tab-content active" id="tab3">
    <form id="educationForm" action="{{ route('education_insert') }}" method="POST">
        @csrf
        <input type="hidden" name="form_step4" value="education_step">
        <h3>Educational Details</h3>
        <button type="button" class="add-row-education action-button" onclick="addEducationRow()">Add Educational Information</button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Course Type</th>
                        <th>Degree</th>
                        <th>University/Board</th>
                        <th>Institution</th>
                        <th>Passing Year</th>
                        <th>Percentage/CGPA</th>
                        <th>Certification Name</th>
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Date of Certificate</th>
                        {{-- <th>Edit</th> --}}
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="educationTableBody">
                    <!-- Pre-populate existing records from the backend -->
                    @foreach($emp_eduction_details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <select name="course_type[]" class="relation-type" onload="toggleLoadFields(this)" required>
                                    <option value="degree" {{ $detail->course_type == 'degree' ? 'selected' : '' }}>Degree</option>
                                    <option value="certification" {{ $detail->course_type == 'certification' ? 'selected' : '' }}>Certification</option>
                                </select>
                            </td>
                            <td><input type="text" name="degree[]" class="degree-input" required value="{{ $detail->degree }}" maxlength="100"></td>
                            <td><input type="text" name="university[]" class="university-input" required value="{{ $detail->university_board }}" maxlength="100"></td>
                            <td><input type="text" name="institution[]" class="institution-input" required value="{{ $detail->institution }}" maxlength="100"></td>
                            <td>
                                <select name="passing_year[]" class="year-input" required>
                                    <option value="{{ $detail->passing_year }}" >{{ $detail->passing_year }}</option>
                                    <?php
                                    $startYear = 1900;
                                    $endYear = date("Y"); // Current year only
                                    for ($year = $startYear; $year <= $endYear; $year++) {
                                        echo "<option value=\"$year\" ".($detail->passing_year == $year ? 'selected' : '').">$year</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="percentage[]" class="percentage-input" required value="{{ $detail->percentage_cgpa }}" maxlength="5"></td>
                            <td><input type="text" name="certification_name[]" class="certification-name-input" required value="{{ $detail->certification_name }}" maxlength="50"></td>
                            <td><input type="text" name="marks_obtained[]" class="marks-input" required value="{{ $detail->marks_obtained }}" maxlength="3"></td>
                            <td><input type="text" name="total_marks[]" class="total-marks-input" required value="{{ $detail->out_of_marks_total_marks }}" maxlength="3"></td>
                            <td><input type="date" name="date_of_certificate[]" class="date-input" value="{{ $detail->date_of_certificate }}" max="{{ date('Y-m-d') }}"></td>
                            {{-- <td><button type="button" onclick="editEducationRow(this)">✏️</button></td> --}}
                            <td>
                                <button type="button" class="delete-button" data-id="{{ $detail->id }}">❌</button>
                                {{-- <form action="{{ route('edu.destroy', $detail->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')">❌</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Button Section -->
        <div class="button-container">
            <a href="{{ route('user.contact') }}" style="text-decoration:none;">
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

<script>
    // Your existing JavaScript functions (addRow, editRow, removeRow, etc.)
    let educationCounter = @json(count($emp_eduction_details)) + 1;

    function addEducationRow() {
        const tableBody = document.getElementById('educationTableBody');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td>${educationCounter}</td>
            <td>
                <select name="course_type[]" class="relation-type" required onchange="toggleFields(this)">
                    <option value="">Select</option>
                    <option value="degree">Degree</option>
                    <option value="certification">Certification</option>
                </select>
            </td>
            <td><input type="text" name="degree[]" class="degree-input" required placeholder="Enter Degree" maxlength="100"></td>
            <td><input type="text" name="university[]" class="university-input" required placeholder="Enter University/Board" maxlength="100"></td>
            <td><input type="text" name="institution[]" class="institution-input" required placeholder="Enter Institution" maxlength="100"></td>
            <td>
                <select name="passing_year[]" class="year-input" required>
                    <option value="" disabled selected>Select Passing Year</option>
                    <?php
                    $startYear = 1900;
                    $endYear = date("Y");
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        echo "<option value=\"$year\">$year</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="text" name="percentage[]" class="percentage-input" required placeholder="Enter Percentage" maxlength="5"></td>
            <td><input type="text" name="certification_name[]" class="certification-name-input" required placeholder="Enter Certification Name" maxlength="50"></td>
            <td><input type="text" name="marks_obtained[]" class="marks-input" required placeholder="Enter Marks Obtained" maxlength="3"></td>
            <td><input type="text" name="total_marks[]" class="total-marks-input" required placeholder="Enter Total Marks" maxlength="3"></td>
            <td><input type="date" name="date_of_certificate[]" class="date-input" max="<?php echo date('Y-m-d'); ?>"></td>
            <td><button type="button" onclick="removeEducationRow(this)">❌</button></td>
        `;
        tableBody.appendChild(newRow);
        educationCounter++; // Increment the counter for new rows
    }


    function toggleFields(selectElement) {
            const row = selectElement.closest('tr');
            const degreeFields = row.querySelectorAll('.degree-input, .university-input, .institution-input, .year-input, .percentage-input');
            const certificationFields = row.querySelectorAll('.certification-name-input, .marks-input, .total-marks-input, .date-input');

            if (selectElement.value === "degree") {
                // Show Degree Fields
                degreeFields.forEach(field => {
                    field.style.display = ""; // Unhide the fields
                    field.removeAttribute('readonly'); // Enable fields
                });

                // Hide Certification Fields
                certificationFields.forEach(field => {
                    field.style.display = "none"; // Hide fields
                    field.setAttribute('readonly', true); // Disable fields
                });
            } else if (selectElement.value === "certification") {
                // Show Certification Fields
                certificationFields.forEach(field => {
                    field.style.display = ""; // Unhide the fields
                    field.removeAttribute('readonly'); // Enable fields
                });

                // Hide Degree Fields
                degreeFields.forEach(field => {
                    field.style.display = "none"; // Hide fields
                    field.setAttribute('readonly', true); // Disable fields
                });
            } else {
                // Hide all fields if no Course Type is selected
                degreeFields.forEach(field => {
                    field.style.display = "none";
                    field.setAttribute('readonly', true);
                });
                certificationFields.forEach(field => {
                    field.style.display = "none";
                    field.setAttribute('readonly', true);
                });
            }
        }

        // Enable all fields before form submission
        document.getElementById('educationForm').addEventListener('submit', function () {
            const degreeInputs = document.querySelectorAll('.degree-input, .university-input, .institution-input, .year-input, .percentage-input');
            const certificationInputs = document.querySelectorAll('.certification-name-input, .marks-input, .total-marks-input, .date-input');

            // Ensure all fields are enabled before submission
            degreeInputs.forEach(input => input.removeAttribute('readonly'));
            certificationInputs.forEach(input => input.removeAttribute('readonly'));
        });

        // Function to remove a row
        function removeEducationRow(button) {
            const row = button.closest('tr');
            row.remove(); // Remove the row
            updateSerialNumbers(); // Update serial numbers after removal
        }

        // Function to update serial numbers of the remaining rows
        function updateSerialNumbers() {
            const rows = document.querySelectorAll('table tbody tr'); // Select all rows in the table body
            let counter = 1; // Start with 1

            rows.forEach(row => {
                const serialCell = row.querySelector('td:first-child'); // Select the first column where serial number is displayed
                const serialInput = row.querySelector('input[name="serial_no[]"]'); // Select the hidden serial number input

                // Update the displayed serial number and the hidden input value
                if (serialCell) serialCell.textContent = counter;
                if (serialInput) serialInput.value = counter;

                counter++; // Increment the counter for the next row
            });
        }

        // Function to edit an education row
        function editEducationRow(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input, select');

            // Check if the row is in edit mode
            if (button.innerText === "✏️") {
                inputs.forEach(input => input.removeAttribute('readonly'));
                button.innerText = "💾"; // Change button text to Save
            } else {
                inputs.forEach(input => input.setAttribute('readonly', true));
                button.innerText = "✏️"; // Change button text back to Edit
            }
        }

        // Event listener to apply validations
        document.addEventListener("DOMContentLoaded", function () {
            // Apply text-to-uppercase for custom-text fields
            const customTextFields = document.querySelectorAll('.custom-text');
            customTextFields.forEach(field => {
                field.addEventListener('input', function () {
                    this.value = this.value.toUpperCase();  // Convert input text to uppercase
                });
            });

            // Apply numeric validation for custom-number fields
            const customNumberFields = document.querySelectorAll('.custom-number');
            customNumberFields.forEach(field => {
                field.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');  // Allow only numeric values
                });
            });
        });

        function toggleLoadFields(selectElement) {
        // Get the parent row of the current select element
        var row = selectElement.closest('tr');

        // Get all the relevant fields in this row
        var degreeField = row.querySelector('input[name="degree[]"]');
        var universityField = row.querySelector('input[name="university[]"]');
        var institutionField = row.querySelector('input[name="institution[]"]');
        var passingYearField = row.querySelector('select[name="passing_year[]"]');
        var percentageField = row.querySelector('input[name="percentage[]"]');
        var certificationNameField = row.querySelector('input[name="certification_name[]"]');
        var marksObtainedField = row.querySelector('input[name="marks_obtained[]"]');
        var totalMarksField = row.querySelector('input[name="total_marks[]"]');
        var dateOfCertificateField = row.querySelector('input[name="date_of_certificate[]"]');
        
        // Check the selected course type value
        var courseType = selectElement.value;

        if (courseType === 'degree') {
            // Disable fields related to Certification
            certificationNameField.disabled = true;
            marksObtainedField.disabled = true;
            totalMarksField.disabled = true;
            dateOfCertificateField.disabled = true;

            // Enable fields related to Degree
            degreeField.disabled = false;
            universityField.disabled = false;
            institutionField.disabled = false;
            passingYearField.disabled = false;
            percentageField.disabled = false;
        } else if (courseType === 'certification') {
            // Disable fields related to Degree
            degreeField.disabled = true;
            universityField.disabled = true;
            institutionField.disabled = true;
            passingYearField.disabled = true;
            percentageField.disabled = true;

            // Enable fields related to Certification
            certificationNameField.disabled = false;
            marksObtainedField.disabled = false;
            totalMarksField.disabled = false;
            dateOfCertificateField.disabled = false;
        }
    }

    // Initialize the form fields based on the initial course_type value
    document.querySelectorAll('.relation-type').forEach(selectElement => {
        toggleFields(selectElement);  // Initialize state on page load
    });

</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
$(document).on('click', '.delete-button', function () {
    // Get the ID of the record to be deleted
    var educationId = $(this).data('id');
  

    // Confirm delete action
    if (confirm('Are you sure you want to delete this item?')) {
        // Send an AJAX DELETE request to the server
        $.ajax({
            url: '/user/del_education/' + educationId,  // Adjust the route URL if necessary
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}', 
                educationId:educationId,// CSRF token for security
            },
            success: function (response) {
                // On success, remove the row from the table
                $('button[data-id="' + educationId + '"]').closest('tr').remove();
                alert('Education record deleted successfully!');
            },
            error: function (response) {
                alert('Error deleting record. Please try again.');
            }
        });
    }
});
document.getElementById('previous-btn-link').addEventListener('click', function(event) {
        event.stopPropagation(); // Stop the form submission from being triggered
    });

</script>

@endsection

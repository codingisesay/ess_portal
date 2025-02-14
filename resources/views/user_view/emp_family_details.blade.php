@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<div class="tab-content active" id="tab5">
    <form id="familyForm" action="submit_step.php" method="POST">
        <!-- <input type="hidden" name="employeeNo" value="P111"> -->
       
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
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="familyTableBody">
                        <!-- Rows will be added dynamically here -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="button-container">
            <button class="previous-btn" type="button">Previous</button>
            <button type="submit" class="next-btn">Next</button>
        </div> -->
        <div class="button-container">
            <button class="previous-btn">
                <span>&#8249;</span>
            </button>
            <button type="submit" class="next-btn">
                <span>&#8250;</span>
            </button>
        </div>

    </form>
</div>
<!-- uppercase bug -->
<script>
    let familyCounter = 1; // Auto-incrementing counter for Family Details
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
        <option value="Sibling">Sibling</option>
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
<td><input type="tel" name="phone_number[]" placeholder="Phone Number"  maxlength="10" pattern="\\d{10}" inputmode="numeric" 
title="Please enter a 10-digit phone number" 
oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
<td><button type="button" onclick="editFamilyRow(this)">✏️</button></td>
<td><button type="button" onclick="removeFamilyRow(this)">❌</button></td>
`;

        tableBody.appendChild(newRow);

        familyCounter++; // Increment the serial counter
    }

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
</script>
  <script src="onboarding_form.js"></script>

@endsection
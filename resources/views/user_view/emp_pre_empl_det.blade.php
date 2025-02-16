@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<div class="tab-content active" id="tab6">
    <form id="employmentForm" action="submit_step.php" method="POST">
        
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
                        <!-- <th>Designation While Joining</th>
                        <th>Role While Joining</th>
                        <th>Designation While Leaving</th>
                        <th>Role While Leaving</th> -->
                        <th>Reason For Leaving</th>
                        <th>Major Responsibilities Held</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="employmentTableBody">
                    <!-- Rows will be added dynamically here -->
                </tbody>
            </table>
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
<select name="country[]" class="country-type" id="country" required>
<option value="">Select Country</option>
<?php
// Include database connection
// include 'db_connection.php';

// Fetch all countries in alphabetical order
// $sql = "SELECT country_name FROM countries ORDER BY country_name ASC";
// $result = mysqli_query($conn, $sql);

// Check if the query was successful
// if ($result) {
//     // Loop through each country and add it as an option
//     while ($row = mysqli_fetch_assoc($result)) {
//         $countryName = htmlspecialchars($row['country_name']);
//         // Check if the country is "India" and set it as the default
//         $selected = ($countryName === "India") ? "selected" : "";
//         echo "<option value='$countryName' $selected>$countryName</option>";
//     }
// } else {
//     // Display an error if the query fails
//     echo "<option value=''>Error fetching countries</option>";
// }
?>
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
<td><button type="button" onclick="editEmploymentRow(this)">✏️</button></td>
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

@endsection
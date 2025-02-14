@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->


<div class="tab-content active" id="tab3">
  <form id="educationForm" action="submit_step.php" method="POST">
      
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
                      <th>Edit</th>
                      <th>Remove</th>
                  </tr>
              </thead>
              <tbody id="educationTableBody">
                  <!-- Rows will be added dynamically here -->
              </tbody>
          </table>
      </div>
      <!-- Button Section -->
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
  let educationCounter = 1; // Auto-incrementing counter for Educational Details

  // Function to add a new row
  function addEducationRow() {
      const tableBody = document.getElementById('educationTableBody');
      const newRow = document.createElement('tr');

      newRow.innerHTML = `
          <td></td> <!-- Serial number will be updated dynamically -->
          <td>
              <select name="course_type[]" class="relation-type" required onchange="toggleFields(this)">
                  <option value="">Select</option>
                  <option value="degree">Degree</option>
                  <option value="certification">Certification</option>
              </select>
          </td>
          <td>
              <input type="custom-text" name="degree[]" class="degree-input" required placeholder="Enter Degree" maxlength="100" 
                  oninput="this.value = this.value.replace(/[^a-zA-Z .,(){}[\\]]/g, '');">
              <input type="hidden" name="serial_no[]" value="">
          </td>
          <td><input type="text" name="university[]" class="university-input" required placeholder="Enter University/Board" maxlength="100"
              onkeydown="return blockNumbers(event);"></td>
          <td><input type="text" name="institution[]" class="institution-input" required placeholder="Enter Institution" maxlength="100"
              onkeydown="return blockNumbers(event);"></td>
          <td>
              <select name="passing_year[]" class="year-input" required>
                  <option value="" disabled selected>Select Passing Year</option>
                  <!-- Generate options dynamically -->
                  <?php
                  $startYear = 1900;
                  $endYear = date("Y"); // Current year only
                  for ($year = $startYear; $year <= $endYear; $year++) {
                      echo "<option value=\"$year\">$year</option>";
                  }
                  ?>
              </select>
          </td>
          <td><input type="text" name="percentage[]" class="percentage-input" required placeholder="Enter Percentage"
              oninput="validatePercentageInput(this)"></td>
          <td>
              <input type="custom-text" name="certification_name[]" required class="certification-name-input" 
                  placeholder="Enter Certification Name" maxlength="50"
                  oninput="this.value = this.value.replace(/[^a-zA-Z .,(){}[\\]]/g, ''); toggleDateOfCertificate(this);">
          </td>
          <td><input type="custom-number" name="marks_obtained[]" class="marks-input" required placeholder="Enter Marks Obtained" 
              maxlength="3"  oninput="this.value = this.value.replace(/[^0-9\\.]/g, '').slice(0, 3)"></td>
          <td><input type="custom-number" name="total_marks[]" class="total-marks-input" required placeholder="Enter Total Marks" 
              maxlength="3"  oninput="this.value = this.value.replace(/[^0-9\\.]/g, '').slice(0, 3)"></td>
          <td>
              <input type="date" name="date_of_certificate[]" class="date-input" 
                  max="<?php echo date('Y-m-d'); ?>" 
                  pattern="\\d{4}-\\d{2}-\\d{2}" 
                  style="pointer-events: none; opacity: 0.6;">
          </td>
          <td><button type="button" onclick="editEducationRow(this)">✏️</button></td>
          <td><button type="button" onclick="removeEducationRow(this)">❌</button></td>
      `;
      tableBody.appendChild(newRow); // Add the new row to the table
      updateSerialNumbers(); // Update serial numbers for all rows
  }

  // Function to enable/disable fields based on Course Type selection
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
</script>
<script src="onboarding_form.js"></script>

@endsection


{{-- <!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Degree and Certification Forms</title>
    <style>
        .form-container {
            margin-top: 20px;
        }
        .form-entry {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin: 10px;
        }
    </style>
</head>
<body>
    
    <!-- Buttons to toggle between Degree and Certification forms -->

    
    <!-- Degree Form Section -->
    <div id="degreeFormSection" class="form-container">
        <h3>Degree Form</h3>
        <button id="addDegreeBtn">Add Degree</button>
        <div id="degreeFormEntries"></div>
       
    </div>

    <!-- Certification Form Section -->
    <div id="certificationFormSection" class="form-container">
        <h3>Certification Form</h3>
        <button id="addCertificationBtn">Add Certification</button>
        <div id="certificationFormEntries"></div>
    </div>
    <button type="submit">Submit</button>
    <a href="{{ route('user.contact') }}" class="btn btn-success">back</a>
    <a href="{{ route('user.bank') }}" class="btn btn-success">next</a>
    <script>
        // Buttons to trigger the form adding
        const addDegreeBtn = document.getElementById("addDegreeBtn");
        const addCertificationBtn = document.getElementById("addCertificationBtn");

        // Divs where form entries will be appended
        const degreeFormEntries = document.getElementById("degreeFormEntries");
        const certificationFormEntries = document.getElementById("certificationFormEntries");

        // Function to add Degree form entry
        function addDegreeForm() {
            const degreeEntry = document.createElement("div");
            degreeEntry.classList.add("form-entry");
            degreeEntry.innerHTML = `

            <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Choose Degree Type:</label>
        <select class="form-control" required>
            <option>Choose Degree Type</option>
                    <option>Bachelor's Degree</option>
                    <option>Master's Degree</option>
                    <option>Doctorate</option>
                    <option>Diploma</option>
                    <option>Others</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Choose Degree Name:</label>
        <select class="form-control" required>
            <option>Choose Degree Name</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex3">University/Board:</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Institution:</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Passing Year:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Percentage/CGPA:</label>
        <input class="form-control" type="number" max="4" step="0.1" placeholder="Enter Percentage/CGPA">
      </div>
    </div> `;
            degreeFormEntries.appendChild(degreeEntry);
        }

        // Function to add Certification form entry
        function addCertificationForm() {
            const certificationEntry = document.createElement("div");
            certificationEntry.classList.add("form-entry");
            certificationEntry.innerHTML = `

            
            <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Type_Certification:</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Certification_Name:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Marks_Obtained:</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Out of Marks (Total Marks):</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Date_Of_Certificate:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
  
    </div>
               
            `;
            certificationFormEntries.appendChild(certificationEntry);
        }

        // Event listeners for adding forms
        addDegreeBtn.addEventListener("click", addDegreeForm);
        addCertificationBtn.addEventListener("click", addCertificationForm);

        // You can add additional functionality here for form validation, submitting, etc.
    </script>

</body>
</html> --}}

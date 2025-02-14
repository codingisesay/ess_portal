@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->


<div class="tab-content active" id="tab4">
  <form action="submit_step.php" method="POST">
     
      <input type="hidden" name="form_step5" value="bank_info">
      <!-- <h3>Bank Information</h3> -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <h3>Personal A/C Details</h3>
              <!-- Personal Account Details -->
              <div class="form-row">

                  <div class="form-group">
                      
                      <select id="bankName1" class="form-control" name="bankName1" placeholder="" required>
                          <option value="">Select a Bank</option>
                          <!-- Add more bank options as needed -->
                      </select>
                      <label for="bankName1">Bank Name <span style="color: red;">*</span></label>
                      <span class="error" id="bankNameError1"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="branchName1" name="branchName1"
                          placeholder="" required>
                          <label for="branchName1">Branch Name <span style="color: red;">*</span></label>
                      <span class="error" id="branchName1Error"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="accountNumber1" name="accountNumber1"
                          placeholder="" maxlength="18" pattern="[A-Za-z0-9]{9,18}"
                          oninput="validateAccountNumber(this)" required>
                          <label for="accountNumber1">Account Number <span style="color: red;">*</span></label>
                      <span class="error" id="accountNumber1Error"></span>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="ifscCode1" name="ifscCode1" maxlength="11"
                          placeholder="Enter IFSC Code" oninput="validateIFSC(this)" required>
                          <label for="ifscCode1">IFSC Code <span style="color: red;">*</span></label>
                      <span class="error" id="ifscCode1Error"></span>
                  </div>
              </div>
          </div>
      </div>


      <!-- salary Account Details -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <div class="correspondence-header1">
                  <h3>Salary Bank Details</h3>
                  <div class="same-address-container">
                      <input type="checkbox" id="copyBankDetails1" class="styled-checkbox2"
                          onclick="copyBankDetails()">
                      <label for="copyBankDetails" class="checkbox-label1">Same as above</label>
                  </div>
              </div>
              <!-- Checkbox to copy Bank 1 details -->



              <div class="form-row">
                  <div class="form-group">
                      
                      <select id="bankName2" class="form-control" placeholder="" name="bankName2">
                          <option value="">Select a Bank</option>
                          <!-- Add more bank options as needed -->
                      </select>
                      <label for="bankName2">Bank Name</label>
                      <!-- <span class="error" id="bankNameError2"></span> -->
                  </div>

                  <div class="form-group">
                     
                      <input type="text" class="form-control" id="branchName2" name="branchName2"
                          placeholder="">
                          <label for="branchName2">Branch Name <span class="branch-name-required"
                          style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="branchName2Error"></span> -->
                  </div>

                  <div class="form-group">
                      
                      <input type="text" id="accountNumber2" class="form-control" name="accountNumber2"
                          placeholder="" maxlength="18" pattern="[A-Za-z0-9]{9,18}"
                          oninput="validateAccountNumber(this)">
                          <label for="accountNumber2">Account Number<span class="account-number-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="accountNumber2Error"></span>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="text" id="ifscCode2" class="form-control" name="ifscCode2" maxlength="11"
                          placeholder="Enter IFSC Code" oninput="validateIFSC(this)">
                          <label for="ifscCode2">IFSC Code<span class="ifsc-code-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="ifscCode2Error"></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <h3>Passport and Visa</h3>
              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="passportNumber" name="passportNumber"
                          placeholder="" maxlength="9"
                          title="Passport Number must be alphanumeric and up to 9 characters long."
                          oninput="togglePassportFields()">
                          <label for="passportNumber">Passport Number</label>
                  </div>

                  <div class="form-group">
                      
                      <select id="issuingCountry" class="form-control" placeholder="" name="issuingCountry">
                          <option value="" disabled selected>Select Issuing Country</option>
                          <!-- Add your country options here -->
                      </select>
                      <label for="issuingCountry">Issuing Country<span class="passport-required"
                              style="display: none; color: red;">*</span></label>
                  </div>

                  <div class="form-group">
                     
                      <input type="date" id="passportIssueDate" class="form-control" name="passportIssueDate"
                          max="<?php echo date('Y-m-d'); ?>" oninput="calculateExpiryDate()"
                          style="pointer-events: none; opacity: 0.6;">
                          <label for="passportIssueDate">Passport Issue Date<span class="passport-required"
                          style="display: none; color: red;">*</span></label>
                      <span class="error" id="passportIssueDateError"></span>
                  </div>
              </div>

              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="date" id="passportExpiryDate" class="form-control"
                          name="passportExpiryDate" style="pointer-events: none; opacity: 0.6;"
                          min="<?php echo date('Y-m-d'); ?>" oninput="validateYear(this)">
                          <label for="passportExpiryDate">Passport Expiry Date<span class="passport-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="passportExpiryDateError"></span> -->
                  </div>


                  <div class="form-group">
                     
                      <select id="usaVisa" class="form-control" name="usaVisa"
                          onchange="toggleVisaExpiryDate()" placeholder="" style="pointer-events: none; opacity: 0.6;">
                          <option value="" disabled selected>Select Yes/No</option>
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                      </select>
                      <label for="usaVisa">Active Visa (Y/N)<span class="passport-required"
                      style="display: none; color: red;">*</span></label>
                      <span class="error" id="usaVisaError"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="date" id="visaExpiryDate" class="form-control" name="visaExpiryDate" min=""
                          onfocus="setMinDate()" style="pointer-events: none; opacity: 0.6;"
                          oninput="validateYear(this)">
                          <label for="visaExpiryDate">Visa Expiry Date<span class="visa-required"
                              style="display: none; color: red;">*</span>
                      </label>
                      <span class="error" id="visaExpiryDateError"></span>
                  </div>



              </div>
          </div>
      </div>

     
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <h3>Vehicle Details</h3>
              <div class="form-row">
                  <div class="form-group">
                      
                      <select id="vehicleType" class="form-control" placeholder="" name="vehicleType">
                          <option value="" selected>Select Vehicle Type</option>
                          <option value="Car">Car</option>
                          <option value="Bike">Bike</option>
                          <!-- <option value="Other">Other</option> -->
                      </select>
                      <label for="vehicleType">Vehicle Type</label>
                      <span class="error" id="vehicleTypeError"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" id="vehicleModel" class="form-control" name="vehicleModel" disabled 
                          placeholder="" oninput="this.value = this.value.toUpperCase()">
                          <label for="vehicleModel">Vehicle Model<span class="vehicle-model-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="vehicleModelError"></span>
                  </div>


                  <div class="form-group">
                      
                      <input type="text" id="vehicleOwner" class="form-control" name="vehicleOwner" disabled 
                          placeholder=""
                          required
                          oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase();">
                          <label for="vehicleOwner">Vehicle Owner<span class="vehicle-owner-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="vehicleOwnerError"></span> -->
                  </div>


              </div>
              <div class="form-row">
                  <div class="form-group">
                     
                      <input type="text" id="registrationNumber" class="form-control" disabled 
                          placeholder="" name="registrationNumber"maxlength="20"
                          oninput="this.value = this.value.toUpperCase()">
                          <label for="registrationNumber">Vehicle Number <span
                              class="registration-number-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="registrationNumberError"></span> -->
                  </div>

                  <div class="form-group">
                     
                      <input type="text" id="insuranceProvider" class="form-control" name="insuranceProvider"
                          placeholder="Enter Insurance Provider" oninput="toggleInsuranceFields()">
                          <label for="insuranceProvider">Insurance Provider<span class="insurance-provider-required" style="color: red; display: none;">*</span></label>
                      <span class="error" id="insuranceProviderError"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="date" id="insuranceExpiry" class="form-control" name="insuranceExpiry"
                          style="pointer-events: none; opacity: 0.6;" oninput="validateYear(this)">
                          <label for="insuranceExpiry">Insurance Expiry Date<span
                              class="insurance-expiry-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="insuranceExpiryError"></span>
                  </div>

              </div>
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


@endsection

<?php 
$id = Auth::guard('web')->user()->id;

?>
{{-- <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>
  
  <body>
  
  
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">TESTING</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><form method="POST" action="{{ route('user.logout') }}">
      @csrf
      <button type="submit" class="btn-primary" style="position:relative; top:10%;">Logout</button>
  </form></li>
        <!-- <li><a href="#">Page 1</a></li>
        <li><a href="#">Page 2</a></li>
        <li><a href="#">Page 3</a></li> -->
      </ul>
    </div>
  </nav>
  
  <div class="container-fluid">
  <h3>Personal A/C Details </h3>
    <form>
    <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">Bank_Name</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
        <div class="col-xs-4">
          <label for="ex2">Branch_Name</label>
          <input class="form-control" id="ex2" type="text" maxlength="20" required>
        </div>
        <div class="col-xs-4">
          <label for="ex3">Account_Number</label>
          <input class="form-control" id="ex3" type="text" required>
        </div>
      </div>
  
      <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">IFSC_Code</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
  </div>
  
  <h3>Salary A/C Details </h3>
    <form>
    <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">Bank_Name</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
        <div class="col-xs-4">
          <label for="ex2">Branch_Name</label>
          <input class="form-control" id="ex2" type="text" maxlength="20" required>
        </div>
        <div class="col-xs-4">
          <label for="ex3">Account_Number</label>
          <input class="form-control" id="ex3" type="text" required>
        </div>
      </div>
  
      <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">IFSC_Code</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
  </div>
  
      <h3>Passport and Visa</h3>
  
      <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">Passport_Number</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
        <div class="col-xs-4">
          <label for="ex2">Issuing_Country</label>
          <input class="form-control" id="ex2" type="text" maxlength="20" required>
        </div>
        <div class="col-xs-4">
          <label for="ex3">Passport_issue_date</label>
          <input class="form-control" id="ex3" type="text" required>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-4">
          <label for="ex1">Passport_expiry_date</label>
          <select class="form-control" required>
              <option value="">Select any one</option>
              <option value=""></option>
          </select>
        </div>
        <div class="col-xs-4">
          <label for="ex2">Active_Visa</label>
          <input class="form-control" id="ex2" type="text" maxlength="20" required>
        </div>
        <div class="col-xs-4">
          <label for="ex3">Visa_expiry_date</label>
          <input class="form-control" id="ex3" type="text" required>
        </div>
      </div>
       
      </div>
   
      
      <a href="{{ route('user.edu') }}" class="btn btn-success">back</a>
      <a href="{{ route('user.family') }}" class="btn btn-success">next</a>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
   --}}

<script>

const today = new Date().toISOString().split('T')[0];  // Format YYYY-MM-DD

// Select all date input fields with the class 'Joining_Date'
const dateFields = document.getElementsByClassName("Joining_Date");

// Loop through each date input field and set the 'max' attribute
for (let i = 0; i < dateFields.length; i++) {
    dateFields[i].setAttribute("max", today);
}


// Select the elements
const maritalStatusSelect = document.getElementById("marital_status");
const anniversaryDateInput = document.getElementById("anv");

// Add an event listener to the marital status select dropdown
maritalStatusSelect.addEventListener("change", function() {
    // Enable Anniversary_Date input for "Married" or "Divorced" options
    if (maritalStatusSelect.value === "Married" || maritalStatusSelect.value === "Divorced") {
        anniversaryDateInput.disabled = false;  // Enable the date input
    } else {
        anniversaryDateInput.disabled = true;   // Disable the date input
        anniversaryDateInput.value = "";        // Clear the value when disabled
    }
});


    /**
                                 * Function to fetch nationalities from an API with retry logic.
                                 */
                                async function fetchNationalities(retries = 3) {
                                    const selectElement = document.getElementById('nationality');

                                    const fetchWithRetries = async () => {
                                        try {
                                            const response = await fetch('https://restcountries.com/v3.1/all', {
                                                headers: { "Content-Type": "application/json" },
                                            });

                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }

                                            const data = await response.json();
                                            populateDropdown(data);
                                        } catch (error) {
                                            console.error("Error fetching nationalities: ", error);

                                            if (retries > 0) {
                                                console.log('Retrying fetch...');
                                                setTimeout(() => fetchWithRetries(retries - 1), 1000);
                                            } else {
                                                alert("Unable to load nationalities after multiple attempts.");
                                            }
                                        }
                                    };

                                    const populateDropdown = (countries) => {
                                        const sortedCountries = countries.sort((a, b) =>
                                            a.name?.common?.localeCompare(b.name?.common)
                                        );

                                        selectElement.innerHTML = ""; // Clear dropdown before appending data
                                        sortedCountries.forEach(country => {
                                            const option = document.createElement('option');
                                            option.value = country.name?.common?.toLowerCase() || '';
                                            option.textContent = country.name?.common || 'Unknown';
                                            selectElement.appendChild(option);
                                        });

                                        // Set default nationality to India if available
                                        const indiaOption = Array.from(selectElement.options).find(option => option.value === "india");
                                        if (indiaOption) {
                                            indiaOption.selected = true;
                                        }
                                    };

                                    // Call the fetch with retry
                                    fetchWithRetries();
                                }

                                // Wait for DOM to load and execute the function
                                document.addEventListener("DOMContentLoaded", function () {
                                    fetchNationalities();
                                });

    </script>
</body>

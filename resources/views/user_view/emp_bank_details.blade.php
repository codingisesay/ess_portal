@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php 
error_reporting(0);
$id = Auth::guard('web')->user()->id;
// dd($emp_bank_datas);

?>

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

<div class="tab-content active" id="tab4">
  <form action="{{ route('bank_insert') }}" method="POST">
     @csrf
      <input type="hidden" name="form_step5" value="bank_info">
      <!-- <h3>Bank Information</h3> -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <h3>Personal A/C Details</h3>
              <!-- Personal Account Details -->
              <div class="form-row">

                  <div class="form-group">
                      
                      <select id="bankName1" class="form-control" name="bankName1" placeholder="" required>
                          <option value="{{ old('bankName1', $emp_bank_datas[0]->per_bank_id) }}">{{ old('bankName1', $emp_bank_datas[0]->per_bank_name) }}</option>
                          @foreach($banks as $bank)
                          <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                          @endforeach
                      </select>
                      <label for="bankName1">Bank Name <span style="color: red;">*</span></label>
                      <span class="error" id="bankNameError1"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="branchName1" name="branchName1"
                          placeholder="" value="{{ old('branchName1', $emp_bank_datas[0]->per_branch_name) }}" required>
                          <label for="branchName1">Branch Name <span style="color: red;">*</span></label>
                      <span class="error" id="branchName1Error"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="accountNumber1" name="accountNumber1"
                          placeholder="" maxlength="18" pattern="[A-Za-z0-9]{9,18}"
                          oninput="validateAccountNumber(this)" value="{{ old('accountNumber1', $emp_bank_datas[0]->per_account_number) }}" required>
                          <label for="accountNumber1">Account Number <span style="color: red;">*</span></label>
                      <span class="error" id="accountNumber1Error"></span>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="text" class="form-control" id="ifscCode1" name="ifscCode1" maxlength="11"
                          placeholder="Enter IFSC Code" oninput="validateIFSC(this)" value="{{ old('ifscCode1', $emp_bank_datas[0]->per_ifsc_code) }}" required>
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
                          <option value="{{ old('bankName2', $emp_bank_datas[0]->sal_bank_id) }}">{{ old('bankName2', $emp_bank_datas[0]->sal_bank_name) }}</option>
                          @foreach($banks as $bank)
                          <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                          @endforeach
                      </select>
                      <label for="bankName2">Bank Name</label>
                      <!-- <span class="error" id="bankNameError2"></span> -->
                  </div>

                  <div class="form-group">
                     
                      <input type="text" class="form-control" id="branchName2" name="branchName2"
                          placeholder="" value="{{ old('branchName2', $emp_bank_datas[0]->sal_branch_name) }}">
                          <label for="branchName2">Branch Name <span class="branch-name-required"
                          style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="branchName2Error"></span> -->
                  </div>

                  <div class="form-group">
                      
                      <input type="text" id="accountNumber2" class="form-control" name="accountNumber2"
                          placeholder="" maxlength="18" pattern="[A-Za-z0-9]{9,18}"
                          oninput="validateAccountNumber(this)" value="{{ old('accountNumber2', $emp_bank_datas[0]->sal_account_number) }}">
                          <label for="accountNumber2">Account Number<span class="account-number-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="accountNumber2Error"></span>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="text" id="ifscCode2" class="form-control" name="ifscCode2" maxlength="11"
                          placeholder="Enter IFSC Code" oninput="validateIFSC(this)" value="{{ old('ifscCode2', $emp_bank_datas[0]->sal_ifsc_code) }}">
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
                          oninput="togglePassportFields()" value="{{ old('passportNumber', $emp_bank_datas[0]->passport_number) }}">
                          <label for="passportNumber">Passport Number</label>
                  </div>

                  <div class="form-group">
                    <span class="error" id="nationalityError"></span>
                      <select  id="nationality" class="form-control" placeholder="" name="issuingCountry">
                          <option value="{{ old('issuingCountry', $emp_bank_datas[0]->issuing_country) }}">{{ old('issuingCountry', $emp_bank_datas[0]->issuing_country) }}</option>
                          <!-- Add your country options here -->
                      </select>
                      <label for="nationality">Issuing Country<span class="passport-required"
                              style="display: none; color: red;">*</span></label>
                  </div>

                  <div class="form-group">
                     
                      <input type="date" id="passportIssueDate" class="form-control" name="passportIssueDate"
                          max="<?php echo date('Y-m-d'); ?>" oninput="calculateExpiry()"
                          style="pointer-events: none; opacity: 0.6;" value="{{ old('passportIssueDate', $emp_bank_datas[0]->passport_issue_date) }}">
                          <label for="passportIssueDate">Passport Issue Date<span class="passport-required"
                          style="display: none; color: red;">*</span></label>
                      <span class="error" id="passportIssueDateError"></span>
                  </div>
              </div>

              <div class="form-row">
                  <div class="form-group">
                      
                      <input type="date" id="passportExpiryDate" class="form-control"
                          name="passportExpiryDate" style="pointer-events: none; opacity: 0.6;"
                          min="<?php echo date('Y-m-d'); ?>" oninput="validateYear(this)" value="{{ old('passportExpiryDate', $emp_bank_datas[0]->passport_expiry_date) }}">
                          <label for="passportExpiryDate">Passport Expiry Date<span class="passport-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="passportExpiryDateError"></span> -->
                  </div>


                  <div class="form-group">
                     
                      <select id="usaVisa" class="form-control" name="usaVisa"
                          onchange="toggleVisaExpiryDate()" placeholder="" style="pointer-events: none; opacity: 0.6;">
                          <option value="{{ old('usaVisa', $emp_bank_datas[0]->active_visa) }}">{{ old('usaVisa', $emp_bank_datas[0]->active_visa) }}</option>
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
                          oninput="validateYear(this)" value="{{ old('visaExpiryDate', $emp_bank_datas[0]->visa_expiry_date) }}">
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
                          <option value="{{ old('vehicleType', $emp_bank_datas[0]->vehicle_type) }}">{{ old('vehicleType', $emp_bank_datas[0]->vehicle_type) }}</option>
                          <option value="Car">Car</option>
                          <option value="Bike">Bike</option>
                          <!-- <option value="Other">Other</option> -->
                      </select>
                      <label for="vehicleType">Vehicle Type</label>
                      <span class="error" id="vehicleTypeError"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="text" id="vehicleModel" class="form-control" name="vehicleModel"
                          placeholder="" oninput="this.value = this.value.toUpperCase()" value="{{ old('vehicleModel', $emp_bank_datas[0]->vehicle_model) }}">
                          <label for="vehicleModel">Vehicle Model<span class="vehicle-model-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="vehicleModelError"></span>
                  </div>


                  <div class="form-group">
                      
                      <input type="text" id="vehicleOwner" class="form-control" name="vehicleOwner" 
                          placeholder=""
                          oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase();" value="{{ old('vehicleOwner', $emp_bank_datas[0]->vehicle_owner) }}">
                          <label for="vehicleOwner">Vehicle Owner<span class="vehicle-owner-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="vehicleOwnerError"></span> -->
                  </div>


              </div>
              <div class="form-row">
                  <div class="form-group">
                     
                      <input type="text" id="registrationNumber" class="form-control" 
                          placeholder="" name="registrationNumber"maxlength="20"
                          oninput="this.value = this.value.toUpperCase()" value="{{ old('registrationNumber', $emp_bank_datas[0]->vehicle_number) }}">
                          <label for="registrationNumber">Vehicle Number <span
                              class="registration-number-required"
                              style="display: none; color: red;">*</span></label>
                      <!-- <span class="error" id="registrationNumberError"></span> -->
                  </div>

                  <div class="form-group">
                     
                      <input type="text" id="insuranceProvider" class="form-control" name="insuranceProvider"
                          placeholder="Enter Insurance Provider" oninput="toggleInsuranceFields()" value="{{ old('insuranceProvider', $emp_bank_datas[0]->insurance_provider) }}">
                          <label for="insuranceProvider">Insurance Provider<span class="insurance-provider-required" style="color: red; display: none;">*</span></label>
                      <span class="error" id="insuranceProviderError"></span>
                  </div>

                  <div class="form-group">
                      
                      <input type="date" id="insuranceExpiry" class="form-control" name="insuranceExpiry"
                          style="pointer-events: none; opacity: 0.6;" oninput="validateYear(this)" value="{{ old('insuranceExpiry', $emp_bank_datas[0]->insurance_expiry_date) }}">
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
<script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>

@endsection

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

// const today = new Date().toISOString().split('T')[0];  // Format YYYY-MM-DD

// // Select all date input fields with the class 'Joining_Date'
// const dateFields = document.getElementsByClassName("Joining_Date");

// // Loop through each date input field and set the 'max' attribute
// for (let i = 0; i < dateFields.length; i++) {
//     dateFields[i].setAttribute("max", today);
// }


// // Select the elements
// const maritalStatusSelect = document.getElementById("marital_status");
// const anniversaryDateInput = document.getElementById("anv");

// // Add an event listener to the marital status select dropdown
// maritalStatusSelect.addEventListener("change", function() {
//     // Enable Anniversary_Date input for "Married" or "Divorced" options
//     if (maritalStatusSelect.value === "Married" || maritalStatusSelect.value === "Divorced") {
//         anniversaryDateInput.disabled = false;  // Enable the date input
//     } else {
//         anniversaryDateInput.disabled = true;   // Disable the date input
//         anniversaryDateInput.value = "";        // Clear the value when disabled
//     }
// });


//     /**
//                                  * Function to fetch nationalities from an API with retry logic.
                                 
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

    
    
                                function calculateExpiry() {
    const issueDateInput = document.getElementById('passportIssueDate');
    const expiryDateInput = document.getElementById('passportExpiryDate');
    
    // Get the selected issue date
    const issueDate = new Date(issueDateInput.value);
    
    if (isNaN(issueDate)) {
        // If the issue date is not valid, do nothing
        return;
    }

    // Add 10 years and subtract 1 day
    const expiryDate = new Date(issueDate);
    expiryDate.setFullYear(issueDate.getFullYear() + 10);  // Add 10 years
    expiryDate.setDate(expiryDate.getDate() - 1);  // Subtract 1 day
    
    // Format the expiry date as YYYY-MM-DD for the input field
    const year = expiryDate.getFullYear();
    const month = (expiryDate.getMonth() + 1).toString().padStart(2, '0');
    const day = expiryDate.getDate().toString().padStart(2, '0');
    
    const formattedExpiryDate = `${year}-${month}-${day}`;
    
    // Set the calculated expiry date in the expiry date input
    expiryDateInput.value = formattedExpiryDate;
}

   </script>
</body>

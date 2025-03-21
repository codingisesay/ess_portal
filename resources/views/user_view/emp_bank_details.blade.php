@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
<?php 
error_reporting(0);
$id = Auth::guard('web')->user()->id;
// dd($emp_bank_datas);

?>

@if(session('success'))
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
@endif

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif

<div class="tab-content active" id="tab4">
  <form action="{{ route('bank_insert') }}" method="POST">
     @csrf
      <input type="hidden" name="form_step5" value="bank_info">
      <!-- <h3>Bank Information</h3> -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-form">
              <h3>Personal A/C Details</h3>
              <button type="button" class="clear-btn" onclick="clearPermanentBankDetails()"><i class="fas fa-undo"></i></button>
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
                          placeholder="" maxlength="18" pattern="\d{9,18}"
                          oninput="validateAccountNumber(this)" value="{{ old('accountNumber1', $emp_bank_datas[0]->per_account_number) }}" required onkeypress="return isNumberKey(event)">
                      <label for="accountNumber1">Account Number <span style="color: red;">*</span></label>
                      <span class="error" id="accountNumber1Error"></span>
                  </div>
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
                  <button type="button" class="clear-btn2" onclick="clearSalaryBankDetails()"><i class="fas fa-undo"></i></button>
                  <div class="same-address-container">
                    
                      <input type="checkbox" id="copyBankDetails1" class="styled-checkbox2"
                          onclick="copyBankDetails()">
                      <label for="copyBankDetails" class="checkbox-label1">Same as above</label>
                  </div>
              </div>
              <!-- Checkbox to copy Bank 1 details -->
              <div class="form-row">
                  <div class="form-group">
                      <select id="bankName2" class="form-control dropdown" placeholder="" name="bankName2">
                          <option value="{{ old('bankName2', $emp_bank_datas[0]->sal_bank_id) }}">{{ old('bankName2', $emp_bank_datas[0]->sal_bank_name) }}</option>
                          @foreach($banks as $bank)
                          <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                          @endforeach
                      </select>
                      <label for="bankName2">Bank Name<span style="color: red;">*</span></label>
                  </div>
                  <div class="form-group">
                      <input type="text" class="form-control" id="branchName2" name="branchName2"
                          placeholder="" value="{{ old('branchName2', $emp_bank_datas[0]->sal_branch_name) }}">
                      <label for="branchName2">Branch Name <span style="color: red;">*</span></label>
                  </div>
                  <div class="form-group">
                      <input type="text" id="accountNumber2" class="form-control" name="accountNumber2"
                          placeholder="" maxlength="18" pattern="\d{9,18}"
                          oninput="validateAccountNumber(this)" value="{{ old('accountNumber2', $emp_bank_datas[0]->sal_account_number) }}" onkeypress="return isNumberKey(event)">
                      <label for="accountNumber2">Account Number<span style="color: red;">*</span></label>
                      <span class="error" id="accountNumber2Error"></span>
                  </div>
                  <div class="form-group">
                      <input type="text" id="ifscCode2" class="form-control" name="ifscCode2" maxlength="11"
                          placeholder="Enter IFSC Code" oninput="validateIFSC(this)" value="{{ old('ifscCode2', $emp_bank_datas[0]->sal_ifsc_code) }}">
                      <label for="ifscCode2">IFSC Code<span style="color: red;">*</span></label>
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
                          onInput="togglePassportFields();"
                          title="Passport Number must be alphanumeric and up to 9 characters long."
                           value="{{ old('passportNumber', $emp_bank_datas[0]->passport_number) }}">
                      <label for="passportNumber">Passport Number</label>
                  </div>
   

                  <div class="form-group">
                      <span class="error" id="nationalityError"></span>
                      <select class="form-control dropdown" name="country">
                          <option value="{{ old('issuingCountry', $emp_bank_datas[0]->issuing_country) }}">{{ old('issuingCountry', $emp_bank_datas[0]->issuing_country) }}</option>
                          <!-- Add your country options here -->
                          @foreach ($countrys as $country)

                          <option value="{{ $country->name }}">{{ $country->name }}</option>
                              
                          @endforeach
                      </select>
                      <label for="nationality">Issuing Country<span class="passport-required "
                              style="display: none; color: red;">*</span></label>
                  </div>
                  <div class="form-group">
                      <input type="date" id="passportIssueDate" class="form-control" name="passportIssueDate"
                          max="<?php echo date('Y-m-d'); ?>" 
                          style="pointer-events: none; opacity: 0.6;" value="{{ old('passportIssueDate', $emp_bank_datas[0]->passport_issue_date) }}">
                      <label for="passportIssueDate">Passport Issue Date<span class="passport-required"
                          style="display: none; color: red;">*</span></label>
                      <span class="error" id="passportIssueDateError"></span>
                  </div>
                  <div class="form-group">
                      <input type="date" id="passportExpiryDate" class="form-control"
                          name="passportExpiryDate" style="pointer-events: none; opacity: 0.6;"
                          min="<?php echo date('Y-m-d'); ?>" oninput="validateYear(this)" value="{{ old('passportExpiryDate', $emp_bank_datas[0]->passport_expiry_date) }}">
                      <label for="passportExpiryDate">Passport Expiry Date<span class="passport-required"
                              style="display: none; color: red;">*</span></label>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <select id="usaVisa" class="form-control dropdown" name="usaVisa"
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
                      <select id="vehicleType" class="form-control dropdown" placeholder="" name="vehicleType">
                          <option value="{{ old('vehicleType', $emp_bank_datas[0]->vehicle_type) }}">{{ old('vehicleType', $emp_bank_datas[0]->vehicle_type) }}</option>
                          <option value="Car">Car</option>
                          <option value="Bike">Bike</option>
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
                  </div>
                  <div class="form-group">
                      <input type="text" id="registrationNumber" class="form-control" 
                          placeholder="" name="registrationNumber"maxlength="20"
                          oninput="this.value = this.value.toUpperCase()" value="{{ old('registrationNumber', $emp_bank_datas[0]->vehicle_number) }}">
                      <label for="registrationNumber">Vehicle Number <span
                              class="registration-number-required"
                              style="display: none; color: red;">*</span></label>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <input type="text" id="insuranceProvider" class="form-control" name="insuranceProvider"
                          placeholder="Enter Insurance Provider" oninput="this.value = this.value.replace(/[0-9]/g, ''); toggleInsuranceFields()" value="{{ old('insuranceProvider', $emp_bank_datas[0]->insurance_provider) }}">
                      <label for="insuranceProvider">Insurance Provider<span class="insurance-provider-required" style="color: red; display: none;">*</span></label>
                      <span class="error" id="insuranceProviderError"></span>
                  </div>
                  <div class="form-group">
                      <input type="date" id="insuranceExpiry" class="form-control" name="insuranceExpiry"
                          style="pointer-events: none; opacity: 0.6;"  min="<?php echo date('Y-m-d'); ?>" oninput="validateYear(this)" value="{{ old('insuranceExpiry', $emp_bank_datas[0]->insurance_expiry_date) }}">
                      <label for="insuranceExpiry">Insurance Expiry Date<span
                              class="insurance-expiry-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="insuranceExpiryError"></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="button-container">
        <a href="{{ route('user.edu') }}" style="text-decoration:none;">
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
<script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>

<script>
    // Function that will be called on page load and on input change
    document.addEventListener('DOMContentLoaded', function () {
        const passportNumberInput = document.getElementById('passportNumber');
        
        // Call togglePassportFields on page load if the passport number is not empty
        const passportNumber = passportNumberInput.value.trim();
        if (passportNumber !== "") {
            togglePassportFields();
        }

        // Add event listener to the passportNumber input field to call togglePassportFields
        passportNumberInput.addEventListener('input', function() {
            const passportNumber = passportNumberInput.value.trim();
            
            // Call the togglePassportFields function only if the input is not empty
            if (passportNumber !== "") {
                togglePassportFields();
            }
        });
    });
</script>

<script>
    // ...existing code...

    document.getElementById('bankName2').addEventListener('change', function () {
        const selectedBank = this.value.trim();

        // Get all dependent fields
        const branchName2 = document.getElementById('branchName2');
        const accountNumber2 = document.getElementById('accountNumber2');
        const ifscCode2 = document.getElementById('ifscCode2');

        // Get asterisk spans
        const branchNameRequired = document.querySelector('.branch-name-required');
        const accountNumberRequired = document.querySelector('.account-number-required');
        const ifscCodeRequired = document.querySelector('.ifsc-code-required');

        if (selectedBank !== "") {
            // Make fields required and show asterisks
            branchName2.setAttribute('required', 'true');
            accountNumber2.setAttribute('required', 'true');
            ifscCode2.setAttribute('required', 'true');

            branchNameRequired.style.display = 'inline';
            accountNumberRequired.style.display = 'inline';
            ifscCodeRequired.style.display = 'inline';
        } else {
            // Remove required attribute and hide asterisks
            branchName2.removeAttribute('required');
            accountNumber2.removeAttribute('required');
            ifscCode2.removeAttribute('required');

            branchNameRequired.style.display = 'none';
            accountNumberRequired.style.display = 'none';
            ifscCodeRequired.style.display = 'none';
        }
    });

    document.getElementById('vehicleType').addEventListener('change', function () {
        const selectedVehicleType = this.value.trim();

        // Get all dependent fields
        const vehicleModel = document.getElementById('vehicleModel');
        const vehicleOwner = document.getElementById('vehicleOwner');
        const registrationNumber = document.getElementById('registrationNumber');

        // Get asterisk spans
        const vehicleModelRequired = document.querySelector('.vehicle-model-required');
        const vehicleOwnerRequired = document.querySelector('.vehicle-owner-required');
        const registrationNumberRequired = document.querySelector('.registration-number-required');

        if (selectedVehicleType !== "") {
            // Make fields required and show asterisks
            vehicleModel.removeAttribute('style');
            vehicleOwner.removeAttribute('style');
            registrationNumber.removeAttribute('style');

            vehicleModel.setAttribute('required', 'true');
            vehicleOwner.setAttribute('required', 'true');
            registrationNumber.setAttribute('required', 'true');

            vehicleModelRequired.style.display = 'inline';
            vehicleOwnerRequired.style.display = 'inline';
            registrationNumberRequired.style.display = 'inline';
        } else {
            // Remove required attribute and hide asterisks
            vehicleModel.setAttribute('style', 'pointer-events: none; opacity: 0.6;');
            vehicleOwner.setAttribute('style', 'pointer-events: none; opacity: 0.6;');
            registrationNumber.setAttribute('style', 'pointer-events: none; opacity: 0.6;');

            vehicleModel.removeAttribute('required');
            vehicleOwner.removeAttribute('required');
            registrationNumber.removeAttribute('required');

            vehicleModelRequired.style.display = 'none';
            vehicleOwnerRequired.style.display = 'none';
            registrationNumberRequired.style.display = 'none';
        }
    });

    document.getElementById('passportIssueDate').addEventListener('input', function() {
    const issueDate = new Date(this.value);
    const expiryDate = new Date(issueDate.setFullYear(issueDate.getFullYear() + 10));
    expiryDate.setDate(expiryDate.getDate() - 1); // Subtract one day from the expiry date
    document.getElementById('passportExpiryDate').value = expiryDate.toISOString().split('T')[0];
});


    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    window.onload = function() {
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

    // ...existing code...
</script>
<script>
    // Function to clear the Permanent Bank Details fields
    function clearPermanentBankDetails() {
        document.getElementById('bankName1').value = '';
        document.getElementById('branchName1').value = '';
        document.getElementById('accountNumber1').value = '';
        document.getElementById('ifscCode1').value = '';
        document.getElementById('bankNameError1').textContent = '';
        document.getElementById('branchName1Error').textContent = '';
        document.getElementById('accountNumber1Error').textContent = '';
        document.getElementById('ifscCode1Error').textContent = '';
    }

    // Function to clear the Salary Bank Details fields
    function clearSalaryBankDetails() {
        document.getElementById('bankName2').value = '';
        document.getElementById('branchName2').value = '';
        document.getElementById('accountNumber2').value = '';
        document.getElementById('ifscCode2').value = '';
        document.getElementById('accountNumber2Error').textContent = '';
        document.getElementById('ifscCode2Error').textContent = '';
        document.getElementById('branchName2Error').textContent = '';
    }
</script>
@endsection

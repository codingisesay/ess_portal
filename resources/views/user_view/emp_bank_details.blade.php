@extends('user_view/employee_form_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
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
                    <br><br>
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
                  </div>
                  <div class="form-group">
                      <input type="text" class="form-control" id="branchName2" name="branchName2"
                          placeholder="" value="{{ old('branchName2', $emp_bank_datas[0]->sal_branch_name) }}">
                      <label for="branchName2">Branch Name <span class="branch-name-required"
                          style="display: none; color: red;">*</span></label>
                  </div>
                  <div class="form-group">
                      <input type="text" id="accountNumber2" class="form-control" name="accountNumber2"
                          placeholder="" maxlength="18" pattern="[A-Za-z0-9]{9,18}"
                          oninput="validateAccountNumber(this)" value="{{ old('accountNumber2', $emp_bank_datas[0]->sal_account_number) }}">
                      <label for="accountNumber2">Account Number<span class="account-number-required"
                              style="display: none; color: red;">*</span></label>
                      <span class="error" id="accountNumber2Error"></span>
                  </div>
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
                      <select id="nationality" class="form-control" placeholder="" name="issuingCountry">
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

    // ...existing code...
</script>

@endsection

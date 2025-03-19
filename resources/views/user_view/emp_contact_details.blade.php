@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php 
error_reporting(0);
$id = Auth::guard('web')->user()->id;
// {{ old('employmentType', $emp_contact_datas[0]->per_building_no) }}
// echo $emp_contact_datas[0]->per_building_no;
// exit();
// dd($emp_contact_datas); 
// dd($countrys);

$name = Auth::guard('web')->user()->name;
$employeeID = Auth::guard('web')->user()->employeeID;
$email = Auth::guard('web')->user()->email;

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
    
  </div>
<div class="tab-content active" id="tab2">
  <form action="{{ route('contact_insert') }}" method="POST" class="address-form">
    @csrf
      <!-- <input type="hidden" name="employeeNo" value=""> -->
      <input type="hidden" name="form_step3" value="form_step3">

      <!-- <h3>Address & Contact Details</h3> -->
      <!-- Address Section -->
      <!-- Address Section -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <div class="address-container">
              <!-- Permanent Address -->

              <div class="address-section">
                  <h3>Permanent Address</h3>
                
                  <button type="button" class="clear-btn" onclick="clearForm()">Clear Adderess</button>


                  <div class="form-row">
                      <div class="form-group">
                         
                          <input type="text" id="permanent_building_no" class="form-control" maxlength="35"
                              name="permanent_building_no" placeholder="" value="{{ old('permanent_building_no', $emp_contact_datas[0]->per_building_no) }}">
                              <label for="permanent_building_no">Building No./Flat No.</label>
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="permanent_premises_name" class="form-control" maxlength="35"
                              name="permanent_premises_name" placeholder="" value="{{ old('permanent_premises_name', $emp_contact_datas[0]->per_name_of_premises) }}" required>
                              <label for="permanent_premises_name">Name of the Premises/Bldg<span
                                  style="color: red;">*</span></label>
                      </div>
                      <div class="form-group">
                        
                          <input type="text" id="permanent_landmark" class="form-control" maxlength="35"
                              name="permanent_landmark" required placeholder="" value="{{ old('permanent_landmark', $emp_contact_datas[0]->per_nearby_landmark) }}">
                              <label for="permanent_landmark">Nearby Landmark<span
                              style="color: red;">*</span></label>
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="permanent_road_street" class="form-control" maxlength="35"
                              name="permanent_road_street" required placeholder="" value="{{ old('permanent_road_street', $emp_contact_datas[0]->per_road_street) }}">
                              <label for="permanent_road_street">Road/Street<span
                                  style="color: red;">*</span></label>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                                
                                <span class="error" id="nationalityError"></span>
                                <select id="nationality_permanent" class="form-control dropdown" name="permanent_country" placeholder="" required>
                                    <option value="{{$emp_contact_datas[0]->per_country}}">{{ $emp_contact_datas[0]->per_country }}</option> <!-- Default value set to India -->
                                    @foreach($countrys as $country)
                                    <option value="{{$country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="nationality">Country <span style="color: red;">*</span></label>
                            </div>

                      <div class="form-group">
                          
                          <input type="text" id="pincode_permanent" name="permanent_pincode" onkeyup="fetchLocationDetails('permanent')"
                              class="form-control" placeholder="" minlength="5"
                              maxlength="6" pattern="\d{5,6}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6); 
       fetchCityAndState('permanent_pincode', 'permanent_city', 'permanent_state', 'permanent_district')" required value="{{ old('permanent_pincode', $emp_contact_datas[0]->per_pincode) }}">
       {{-- <input type="text" id="pincode_permanent" value="" placeholder="Enter PIN code" class="form-control pincode" name="pincode_permanent" onkeyup="fetchLocationDetails('permanent')" required /> --}}
       <label for="permanent_pincode">Pincode/Zipcode<span style="color: red;"
       id="pincode-required">*</span></label>
                      </div>
                      <div class="form-group">
                         
                          <input type="text" id="district_permanent" name="permanent_district" required maxlength="35"
                              class="form-control" placeholder="" value="{{ old('district_permanent', $emp_contact_datas[0]->per_district) }}">
                              <label for="permanent_district">District<span style="color: red;">*</span></label>
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="city_permanent" name="permanent_city" required maxlength="35"
                              class="form-control" placeholder="" value="{{ old('permanent_city', $emp_contact_datas[0]->per_city) }}">
                              <label for="permanent_city">City/Town/Village<span
                                  style="color: red;">*</span></label>
                      </div>

                      <div class="form-group">
                          
                          <input type="text" id="state_permanent" name="permanent_state" required maxlength="35"
                              class="form-control" placeholder="" value="{{ old('permanent_state', $emp_contact_datas[0]->per_state) }}">
                              <label for="permanent_state">State/Province<span
                                  style="color: red;">*</span></label>
                      </div>


                  </div>
              </div>


              <!-- Correspondence Address -->
              
              <div class="address-section">
                  <div class="correspondence-header">
                      <h3 class="address-title">Correspondence Address</h3>
                      <div class="same-address-container">
                        
                          <input type="checkbox" id="copy_address_checkbox" class="styled-checkbox"
                              onclick="copyPermanentToCorrespondence()">
                          <label for="same_as_permanent" class="checkbox-label">Same as above</label>
                      </div>
                  </div>


                  <div class="form-row">
                      <div class="form-group">
                         
                          <input type="text" id="correspondence_building_no" name="correspondence_building_no" maxlength="35" 
                              class="form-control" placeholder="" value="{{ old('correspondence_building_no', $emp_contact_datas[0]->cor_building_no) }}">
                              <label for="correspondence_building_no">Building No./Flat No.</label>
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="correspondence_premises_name" class="form-control" maxlength="35" 
                              name="correspondence_premises_name" placeholder="" value="{{ old('correspondence_premises_name', $emp_contact_datas[0]->cor_name_of_premises) }}">
                              <label for="correspondence_premises_name">Name of the Premises/Bldg</label>
                          
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="correspondence_landmark" name="correspondence_landmark" maxlength="35" 
                              class="form-control" placeholder="" value="{{ old('correspondence_landmark', $emp_contact_datas[0]->cor_nearby_landmark) }}">
                              <label for="correspondence_landmark">Nearby Landmark</label>   
                      </div>
                      <div class="form-group">
                         
                          <input type="text" id="correspondence_road_street" name="correspondence_road_street" maxlength="35" 
                              class="form-control" placeholder="Enter Road/Street" value="{{ old('correspondence_road_street', $emp_contact_datas[0]->cor_road_street) }}">
                              <label for="correspondence_road_street">Road/Street
                              </label>
                      </div>
                     

                      <div class="form-group">
                                
                        <span class="error" id="nationalityError"></span>
                        <select id="nationality_correspondence" class="form-control dropdown" name="correspondence_country" placeholder="" >
                            <option value="{{$emp_contact_datas[0]->cor_country}}">{{$emp_contact_datas[0]->cor_country}}</option> <!-- Default value set to India -->
                            @foreach($countrys as $country)
                            <option value="{{$country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <label for="nationality">Country</label>
                    </div>
                      <div class="form-group">
                          
                          <input type="text" id="pincode_correspondence" name="correspondence_pincode" onkeyup="fetchLocationDetails('correspondence')"
                              class="form-control" placeholder="" minlength="5" 
                              maxlength="6" pattern="\d{5,6}"
                              oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6); 
       fetchCityAndState('correspondence_pincode', 'correspondence_city', 'correspondence_state', 'correspondence_district')" value="{{ old('correspondence_pincode', $emp_contact_datas[0]->cor_pincode) }}">
       <label for="correspondence_pincode">Pincode/Zipcode <span id="pincode-asterisk"></span></label>
                      </div>
                      <div class="form-group">
                          
                          <input type="text" id="district_correspondence" name="correspondence_district" maxlength="35" 
                              class="form-control" placeholder="" value="{{ old('correspondence_district', $emp_contact_datas[0]->cor_district) }}">
                              <label for="correspondence_district">District
                          </label>
                      </div>
                      <div class="form-group">
                         
                          <input type="text" id="city_correspondence" name="correspondence_city" maxlength="35" 
                              class="form-control" placeholder="" value="{{ old('correspondence_city', $emp_contact_datas[0]->cor_city) }}">
                              <label for="correspondence_city">City/Town/Village
                              </label>
                      </div>
                  </div>
                  <div class="form-row">
                      

                      <div class="form-group">
                          
                          <input type="text" id="state_correspondence" name="correspondence_state" maxlength="35" 
                              class="form-control" placeholder="" value="{{ old('correspondence_state', $emp_contact_datas[0]->cor_state) }}">
                              <label for="correspondence_state">State/Province
                          </label>
                      </div>
                  </div>
              </div>
          </div>
      </div>
     
      <!-- Contact Details -->
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">

          <h3>Contact Details</h3>
          <div class="form-row">
             
              <div class="form-group">
              
                  <input id="phoneNumber" name="phoneNumber" class="form-control"
                      placeholder="" type="tel" pattern="\d{10}"
                      title="Phone Number must be exactly 10 digits." required maxlength="10"
                      oninput="validatePhoneNumbers()" value="{{ old('phoneNumber', $emp_contact_datas[0]->offical_phone_number) }}">
                      <label for="phoneNumber">Offical Phone Number<span style="color: red;">*</span></label>
                  <span class="error" id="phoneNumberError"></span>
              </div>
             
              <div class="form-group">
              
                  <input id="alternate_phone_number" class="form-control" name="alternate_phone_number"
                      placeholder="" type="tel" pattern="\d{10}"
                      title="Alternate Phone Number must be exactly 10 digits." maxlength="10"
                      oninput="validatePhoneNumbers()" value="{{ old('alternate_phone_number', $emp_contact_datas[0]->alternate_phone_number) }}">
                      <label for="alternate_phone_number">Alternate Phone Number</label>
                     
                  <span class="error" id="alternatePhoneNumberError"></span>
              </div>
              <div class="form-group">
                  
                  <input type="email" id="emailID" name="emailID" class="form-control"
                      placeholder=""
                      pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required value="{{ old('emailID', $emp_contact_datas[0]->email_address) }}">
                      <label for="emailID">Email Address<span style="color: red;">*</span></label>
                  <span class="error" id="emailIDError"></span> <!-- Ensure this element exists -->
              </div>
              <div class="form-group">
                  
                  <input type="email" id="email" name="email" class="form-control"
                      placeholder=""
                      pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required value="{{ $email }}" readonly>
                      <label for="emailID">Offical Email Address<span style="color: red;">*</span></label>
                  <span class="error" id="emailIDError"></span>
              </div>
                        </div>
      </div>
      <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
          <h3>Emergency Contact Details</h3>
          <div class="address-form1">
              <div class="form-row1">
                  <div class="form-group">
                      
                      <input type="text" id="emergency_contact_name" class="form-control"
                          name="emergency_contact_name" placeholder="" required
                          oninput="validateEmergencyContactName()" value="{{ old('emergency_contact_name', $emp_contact_datas[0]->emergency_contact_person) }}">
                          <label for="emergency_contact_name">Emergency Contact Person<span
                              style="color: red;">*</span></label>
                      <span class="error" id="emergencyContactNameError" style="color: red;"></span>
                  </div>

                 

                
                  <div class="form-group">
                  
                      <input id="emergency_contact_number" class="form-control" placeholder=""
                          name="emergency_contact_number" 
                          type="tel" pattern="\d{10}"
                          title="Emergency Contact Number must be exactly 10 digits." maxlength="10" required
                          oninput="validatePhoneNumbers()"  value="{{ old('emergency_contact_number', $emp_contact_datas[0]->emergency_contact_number) }}">
                          <label for="emergency_contact_number">Emergency Contact Number<span
                  style="color: red;">*</span></label>
                          
                      <span class="error" id="emergencyContactNumberError"></span>
                  </div>
              </div>
          </div>
      </div>



    
      <div class="button-container">
        <a href="{{ route('user.dashboard') }}" style="text-decoration:none;">
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

window.onload = function() {
        // Get all the select elements
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
          const selectedValue = dropdown.value;
    
          // Loop through each dropdown's options and hide the selected one
          for (let option of dropdown.options) {
            if (option.value === selectedValue) {
              option.style.display = 'none';  // Hide the selected option
              break; // Only hide the selected option
            }
          }
        });

        // Initialize the pincode asterisk display based on the default country value
        togglePincodeAsterisk();
      };

function getSelectedCountryValue() {
    var selectElement = document.getElementById("nationality_permanent");
    var selectedValue = selectElement.value;
    console.log(selectedValue); // Logs the selected value
}
window.onload = function() {
    // Your function to access the select value
    getSelectedCountryValue();
};

function togglePincodeAsterisk() {
    const permanentCountryInput = document.getElementById('nationality_permanent').value;
    const correspondenceCountryInput = document.getElementById('nationality_correspondence').value;
    const permanentPincodeAsterisk = document.getElementById('pincode-required');
    const correspondencePincodeAsterisk = document.getElementById('pincode-asterisk');

    if (permanentCountryInput.trim().toLowerCase() === 'india') {
        permanentPincodeAsterisk.style.display = 'inline'; // Show the asterisk
    } else {
        permanentPincodeAsterisk.style.display = 'none'; // Hide the asterisk
    }

    if (correspondenceCountryInput.trim().toLowerCase() === 'india') {
        correspondencePincodeAsterisk.style.display = 'inline'; // Show the asterisk
    } else {
        correspondencePincodeAsterisk.style.display = 'none'; // Hide the asterisk
    }
}

// Add event listeners to country dropdowns to toggle the asterisk
document.getElementById('nationality_permanent').addEventListener('change', togglePincodeAsterisk);
document.getElementById('nationality_correspondence').addEventListener('change', togglePincodeAsterisk);

    
    //fetch by pin code
    
    // Function to fetch district, city, and state based on pincode for either Permanent or Correspondence address
    async function fetchLocationDetails(addressType) {
        const pincode = document.getElementById(`pincode_${addressType}`).value;
        const stateField = document.getElementById(`state_${addressType}`);
        const cityField = document.getElementById(`city_${addressType}`);
        const districtField = document.getElementById(`district_${addressType}`);
    
        // Make sure pincode is at least 6 characters long
        if (pincode.length < 6) {
            return;
        }
    
        // Clear the previous values
        stateField.value = '';
        cityField.value = '';
        districtField.value = '';
    
        try {
            // Call API to fetch data based on pincode
            const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
            
            if (!response.ok) {
                throw new Error('Unable to fetch location details.');
            }
    
            const data = await response.json();
            
            if (data[0].Status === "Success") {
                const place = data[0].PostOffice[0];
    
                // Populate the State input
                stateField.value = place.State || 'Not Available';
    
                // Populate the City input (or Taluk)
                cityField.value = place.Taluk || place.District || 'Not Available';
    
                // Populate the District input
                districtField.value = place.District || 'Not Available';
            } else {
                alert('No data found for this pincode.');
            }
        } catch (error) {
            console.error("Error fetching location details:", error);
            alert('Error fetching location details.');
        }
    }
    
    // Function to copy Permanent Address to Correspondence Address
    function copyPermanentToCorrespondence() {
        // Check if the checkbox is checked
        const isChecked = document.getElementById('copy_address_checkbox').checked;
        
        if (isChecked) {
            // Copy the values from Permanent Address to Correspondence Address
            document.getElementById('correspondence_building_no').value = document.getElementById('permanent_building_no').value;
            document.getElementById('correspondence_premises_name').value = document.getElementById('permanent_premises_name').value;
            document.getElementById('correspondence_landmark').value = document.getElementById('permanent_landmark').value;
            document.getElementById('correspondence_road_street').value = document.getElementById('permanent_road_street').value;
            document.getElementById('nationality_correspondence').value = document.getElementById('nationality_permanent').value;
            document.getElementById('pincode_correspondence').value = document.getElementById('pincode_permanent').value;
            document.getElementById('district_correspondence').value = document.getElementById('district_permanent').value;
            document.getElementById('city_correspondence').value = document.getElementById('city_permanent').value;
            document.getElementById('state_correspondence').value = document.getElementById('state_permanent').value;
        } else {
            // Clear the Correspondence Address fields if checkbox is unchecked
            document.getElementById('correspondence_building_no').value = '';
            document.getElementById('correspondence_premises_name').value = '';
            document.getElementById('correspondence_landmark').value = '';
            document.getElementById('correspondence_road_street').value = '';
            document.getElementById('nationality_correspondence').value = '';
            document.getElementById('pincode_correspondence').value = '';
            document.getElementById('district_correspondence').value = '';
            document.getElementById('city_correspondence').value = '';
            document.getElementById('state_correspondence').value = '';
        }
    }
    
        document.getElementById('previous-btn-link').addEventListener('click', function(event) {
            event.stopPropagation(); // Stop the form submission from being triggered
        });
        </script>

<script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>

<style>
          .clear-btn {
              position: absolute;
              top: 10px;
              right: 20px;
              background-color: #ff0000;
              color: #fff;
              padding: 8px 16px;
              border: none;
              border-radius: 4px;
              cursor: pointer;
              font-size: 14px;
              font-weight: bold;
          }

          .clear-btn:hover {
              background-color: #e60000;
          }

          .clear-btn:focus {
              outline: none;
          }

          .clear-btn:active {
              background-color: #d40000;
          }
      </style>

@endsection
</body>

<?php 
$id = Auth::guard('web')->user()->id;

?>
<head>
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
<h3>Permanent Address</h3>
  <form action="{{ route('contact_insert') }}" method="post">
    @csrf
    @foreach($emp_contact_datas as $emp_contact_data)
  <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Building_No</label>
        <input class="form-control" id="building_no_permanent" name="building_no_permanent" type="text" value="{{$emp_contact_data->per_building_no}}" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Name_Of_Premises</label>
        <input class="form-control" id="name_of_premises_permanent" name="name_of_premises_permanent" value="{{$emp_contact_data->per_name_of_premises}}" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Nearby_Landmark</label>
        <input class="form-control" id="nearby_landmark_permanent" name="nearby_landmark_permanent"  value="{{$emp_contact_data->per_nearby_landmark}}" type="text" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Road_Street</label>
        <input class="form-control" id="road_street_permanent" value="{{$emp_contact_data->per_road_street}}" name="road_street_permanent" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
     
    <label for="nationality_permanent">Permanent Address Nationality</label>
    <select id="nationality_permanent" class="form-control" name="nationality_permanent" required>
        <option value="{{$emp_contact_data->per_country}}" disabled selected>Select Nationality</option>
    </select>

</div>
<div class="col-xs-4">
    <label for="pincode">Pincode</label>
    <input type="text" id="pincode_permanent" value="{{$emp_contact_data->per_pincode}}" class="form-control pincode" name="pincode_permanent" onkeyup="fetchLocationDetails('permanent')" required />
</div>
    </div>

    <div class="form-group row">
    <div class="col-xs-4">
    <label for="state">State</label>
    <input type="text" id="state_permanent" value="{{$emp_contact_data->per_state}}" class="form-control" name="state_permanent" readonly />
</div>

<div class="col-xs-4">
    <label for="city">City</label>
    <input type="text" id="city_permanent" value="{{$emp_contact_data->per_city}}" class="form-control" name="city_permanent" readonly />
</div>

<div class="col-xs-4">
    <label for="district">District</label>
    <input type="text" id="district_permanent" value="{{$emp_contact_data->per_district}}" class="form-control" name="district_permanent" readonly />
</div>


<div class="form-group">
    <input type="checkbox" id="copy_address_checkbox" onclick="copyPermanentToCorrespondence()">
    <label for="copy_address_checkbox">Copy Permanent Address to Correspondence Address</label>
</div>

    <h3>Correspondence Address</h3>
    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Building_No</label>
        <input class="form-control" id="building_no_correspondence" value="{{$emp_contact_data->cor_building_no}}" name="building_no_correspondence" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Name_Of_Premises</label>
        <input class="form-control" id="name_of_premises_correspondence" value="{{$emp_contact_data->cor_name_of_premises}}" name="name_of_premises_correspondence" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Nearby_Landmark</label>
        <input class="form-control" id="nearby_landmark_correspondence" value="{{$emp_contact_data->cor_nearby_landmark}}" name="nearby_landmark_correspondence" type="text" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Road_Street</label>
        <input class="form-control" id="road_street_correspondence" value="{{$emp_contact_data->cor_road_street}}" name="road_street_correspondence" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
      
    <label for="nationality_correspondence">Correspondence Address Nationality</label>
    <select id="nationality_correspondence" class="form-control" name="nationality_correspondence" required>
        <option value="{{$emp_contact_data->cor_country}}" disabled selected>Select Nationality</option>
    </select>
</div>
      <div class="col-xs-4">
        <label for="ex3">Pincode</label>
        <input type="text" id="pincode_correspondence" value="{{$emp_contact_data->cor_pincode}}" class="form-control pincode" name="pincode_correspondence" onkeyup="fetchLocationDetails('correspondence')" required />
      </div>
</div>
      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex2">City</label>
        <input type="text" id="city_correspondence" value="{{$emp_contact_data->cor_city}}" class="form-control" name="city_correspondence" readonly />
      </div>
      <div class="col-xs-4">
        <label for="ex3">State</label>
        <input type="text" id="state_correspondence" value="{{$emp_contact_data->cor_state}}" class="form-control" name="state_correspondence" readonly />
      </div>
    <div class="col-xs-4">
    <label for="district">District</label>
    <input type="text" id="district_correspondence" value="{{$emp_contact_data->cor_district}}" class="form-control" name="district_correspondence" readonly />
</div>
</div>


    <h3>Contact details</h3>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Offical Phone_Number</label>
        <input class="form-control" id="ex3" type="number" value="{{$emp_contact_data->offical_phone_number}}" name="Offical_Phone_Number" maxlength="10" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Alternate_Phone_Number</label>
        <input class="form-control" id="ex2" value="{{$emp_contact_data->alternate_phone_number}}" name="Alternate_Phone_Number" type="number" maxlength="10">
      </div>
      <div class="col-xs-4">
        <label for="ex3">Email_Address</label>
        <input class="form-control" id="ex3" value="{{$emp_contact_data->email_address}}" name="Email_Addres" type="email" required>
      </div>
    </div>

    <div class="form-group row">
      
      <div class="col-xs-4">
        <label for="ex2">Offical Email Address</label>
        <input class="form-control" id="ex2" value="{{$emp_contact_data->offical_email_address}}" name="Offical_Email_Address" type="email"  required>
      </div>
     
    </div>


    <h3>Emergency Contact Details </h3>
    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Emergency_Contact_Person</label>
        <input class="form-control" id="ex2" value="{{$emp_contact_data->emergency_contact_person}}" name="Emergency_Contact_Person" type="text"  required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Emergency_Contact_Number</label>
        <input class="form-control" id="ex2" type="number" value="{{$emp_contact_data->emergency_contact_number}}" name="Emergency_Contact_Number" maxlength="10" required>
      </div>
    </div>
    <a href="{{ route('user.dashboard') }}" class="btn btn-success">Back</a>
    <button type="submit" class="btn btn-success">Submit</button>
    <a href="{{ route('user.edu') }}" class="btn btn-success">next</a>
    @endforeach
  </form>
</div>
</div>

@if($errors->any())
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
                @endif
<script>

//fetch country
async function fetchNationalities(retries = 3) {
        const selectPermanent = document.getElementById('nationality_permanent');
        const selectCorrespondence = document.getElementById('nationality_correspondence');

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
                    console.log('Retrying fetch... Remaining retries: ', retries);
                    setTimeout(() => fetchWithRetries(retries - 1), 1000);
                } else {
                    alert("Unable to load nationalities after multiple attempts.");
                }
            }
        };

        const populateDropdown = (countries) => {
            // Sort countries by name in alphabetical order
            const sortedCountries = countries.sort((a, b) =>
                a.name?.common?.localeCompare(b.name?.common)
            );

            // Populate both select elements
            [selectPermanent, selectCorrespondence].forEach(selectElement => {
                selectElement.innerHTML = ""; // Clear dropdown before appending data

                sortedCountries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name?.common?.toLowerCase() || '';
                    option.textContent = country.name?.common || 'Unknown';
                    selectElement.appendChild(option);
                });

                // Optionally, set a default nationality (e.g., "India")
                const indiaOption = Array.from(selectElement.options).find(option => option.value === "india");
                if (indiaOption) {
                    indiaOption.selected = true;
                }
            });
        };

        // Call the fetch function with retries
        fetchWithRetries();
    }

    // Wait for DOM to load and execute the function
    document.addEventListener("DOMContentLoaded", function () {
        fetchNationalities();
    });



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
        document.getElementById('building_no_correspondence').value = document.getElementById('building_no_permanent').value;
        document.getElementById('name_of_premises_correspondence').value = document.getElementById('name_of_premises_permanent').value;
        document.getElementById('nearby_landmark_correspondence').value = document.getElementById('nearby_landmark_permanent').value;
        document.getElementById('road_street_correspondence').value = document.getElementById('road_street_permanent').value;
        document.getElementById('nationality_correspondence').value = document.getElementById('nationality_permanent').value;
        document.getElementById('pincode_correspondence').value = document.getElementById('pincode_permanent').value;
        document.getElementById('state_correspondence').value = document.getElementById('state_permanent').value;
        document.getElementById('city_correspondence').value = document.getElementById('city_permanent').value;
        document.getElementById('district_correspondence').value = document.getElementById('district_permanent').value;
    } else {
        // Clear the Correspondence Address fields if checkbox is unchecked
        document.getElementById('building_no_correspondence').value = '';
        document.getElementById('name_of_premises_correspondence').value = '';
        document.getElementById('nearby_landmark_correspondence').value = '';
        document.getElementById('road_street_correspondence').value = '';
        document.getElementById('nationality_correspondence').value = '';
        document.getElementById('pincode_correspondence').value = '';
        document.getElementById('state_correspondence').value = '';
        document.getElementById('city_correspondence').value = '';
        document.getElementById('district_correspondence').value = '';
    }
}
   
    </script>
</body>

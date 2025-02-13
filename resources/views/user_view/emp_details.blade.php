<?php 
$id = Auth::guard('web')->user()->id;

// dd($results);

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

  <form action="{{ route('detail_insert') }}" method="POST">
    @csrf
    @foreach($results as $res)
    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Employee_Type</label>
        <select class="form-control dropdown" name="emp_type" required>
            <option value="{{$res->employee_type}}">{{$res->employee_type_name}}</option>
        @foreach($emp_types as $emp_type)
    
            <option value="{{$emp_type->id}}">{{$emp_type->name}}</option>
  
        @endforeach
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Employee_No</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" name="employee_no" value="{{$res->employee_no}}" required placeholder="STPL0010">
      </div>
      <div class="col-xs-4">
        <label for="ex3">Employee_Name</label>
        <input class="form-control" id="ex3" type="text" placeholder="Enter Your Name" value="{{$res->employee_name}}" name="employee_name" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Joining_Date</label>
        <input class="form-control Joining_Date" id="Joining_Date" type="date" value="{{$res->Joining_date}}" name="joining_date" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Reporting_Manager</label>
        <select class="form-control dropdown" name="reporting_manager" required>
        <option value="{{$res->reporting_manager_id}}">{{$res->reporting_manager_name}}</option>
        @foreach($users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
</select>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Total_Experience</label>
        <input class="form-control" id="ex3" type="number" name="total_exp" value="{{ $res->total_experience }}" placeholder="Enter your Experience">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Designation</label>
        <select class="form-control dropdown" name="designation" required>
        <option value="{{ $res->designation_id }}">{{ $res->role_name }}</option>
        @foreach($designations as $designation)
        <option value="{{$designation->id}}">{{$designation->name}}</option>
        @endforeach
</select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Department</label>
        <select class="form-control dropdown" name="department" required>
        <option value="{{$res->department_id}}">{{$res->department_name}}</option>
        @foreach($departments as $department)
        <option value="{{$department->id}}">{{$department->name}}</option>
        @endforeach
</select>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Gender</label>
        <select class="form-control dropdown" name="gender" required>
        <option value="{{$res->gender}}">{{$res->gender}}</option>
       
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="others">other</option>

</select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Date_Of_Birth</label>
        <input class="form-control Joining_Date" id="ex1" value="{{$res->date_of_birth}}" name="birth_date" type="date" required>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Blood_Group</label>
        <select class="form-control dropdown" name="blood_group" required>
        <option value="{{$res->blood_group}}">{{$res->blood_group}}</option>
       
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>

</select>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Nationality</label>
        <select id="nationality" class="form-control" name="nationality" required>
                                    <option value="{{$res->nationality}}" disabled selected>{{$res->nationality}}</option>
                                </select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Religion</label>
        <select class="form-control dropdown" name="religion" required>
        <option value="{{$res->religion}}">{{$res->religion}}</option>
       
        <option value="Hinduism">Hinduism</option>
        <option value="Islam">Islam</option>
        <option value="Christianity">Christianity</option>
        <option value="Sikhism">Sikhism</option>
        <option value="Buddhism">Buddhism</option>
        <option value="Jainism">Jainism</option>
        <option value="Zoroastrianism">Zoroastrianism</option>
        <option value="Judaism">Judaism</option>
        <option value="Bahá'í Faith">Bahá'í Faith</option>
        <option value="Other">Other</option>

</select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Marital_Status</label>
        <select class="form-control dropdown" id="marital_status" name="marital_status" required>
        <option value="{{$res->marital_status}}">{{$res->marital_status}}</option>
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Divorced">Divorced</option>

</select>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Anniversary_Date</label>
        <input class="form-control Joining_Date" id="anv" value='{{$res->anniversary_date}}' name="anniversary_date" type="date" disabled>
    
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Universal_Account_Number</label>
        <!-- <input class="form-control" id="ex1" type="number"> -->
        <input class="form-control" id="ex1" type="text" pattern="\d{12}" maxlength="12" value="{{$res->universal_account_number}}" name="uan" title="Please enter exactly 12 digits" placeholder="Please enter exactly 12 digits">
      </div>
      <div class="col-xs-4">
        <label for="ex2">Provident_Fund</label>
        <input class="form-control" id="ex2" type="text" maxlength="22" placeholder="PF" value="{{$res->provident_fund}}" name='pf'>
      </div>
      <div class="col-xs-4">
        <label for="ex3">ESIC_No</label>
        <input class="form-control" id="ex3" type="number"  maxlength="17" placeholder="ESIC_No" value="{{$res->esic_no}}" name="esic">
      </div>
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
    <a href="{{ route('user.contact') }}" class="btn btn-success">next</a>
    @endforeach
  </form>
</div>
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
  };





    </script>
</body>

@extends('user_view/employee_form_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<?php 
error_reporting(0);
$id = Auth::guard('web')->user()->id;
$name = Auth::guard('web')->user()->name;
$employeeID = Auth::guard('web')->user()->employeeID;

// dd($results);


// dd($results);

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


<div class="tab-content active" id="tab1">


    <form action="{{ route('detail_insert') }}" method="POST">
        @csrf
        <input type="hidden" name="form_step" value="form_step">
        <!-- Hidden input to identify the step -->
        <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
            <div class="address-form">
                <h3>Employee Details</h3>
                <!-- Left Column with border -->
                <div class="form-row">
                    <div class="form-group">
                        
                        <select id="employmentType" class="form-control dropdown" name="employmentType" placeholder="" required>
                            <option value="{{ old('employmentType', $results[0]->employee_type_name) }}">{{ old('employmentType', $results[0]->employee_type_name) }}</option>
                            @foreach($emp_types as $emp_type)
                            <option value="{{$emp_type->id}}">{{$emp_type->name}}</option>
                            @endforeach
                        </select>
                        <label for="employmentType">Employment Type<span style="color: red;">*</span></label>
                        <!-- <span class="error" id="employmentTypeError"></span> -->
                    </div>
    
    
                    <div class="form-group">
                       
                        <input type="text" id="employeeNo" class="form-control" name="employeeNo"
                            value="{{$employeeID}}" readonly placeholder="" required>
                            <label for="employeeNo">Employee No</label>
                        <!-- <span class="error" id="employeeNoError"></span> -->
                      
                    </div>
                    
    
                    <div class="form-group">
                        <input type="text" id="employeeName" class="form-control" name="employeeName"
                            value="{{$name}}" readonly required placeholder="">
                        <label for="employeeName">Employee Name</label>
                    </div>
    
                    <!-- <div class="form-group">
                    <label for="designation">
                        Designation <span style="color: red;">*</span>
                    </label>
                    <select id="designation" name="designation" required>
                        <option value="">Select Designation</option>
                        <?php
                        // include 'db_connection.php'; // Your database connection file
                        // Fetch designations from the database
                        // $sql = "SELECT designation FROM designations"; // Select only designation
                        // $result = mysqli_query($conn, $sql);
                        // Populate dropdown options
                        // while ($row = mysqli_fetch_assoc($result)) {
                        //     echo "<option value='" . htmlspecialchars($row['designation']) . "'>" . htmlspecialchars($row['designation']) . "</option>";
                        // }
                        ?>
                    </select>
    
                    <span class="error" id="designationError"></span> 
                </div> -->
    
    
                </div>
    
                <!-- Right Column with border -->
                <div class="form-row">
                    <div class="form-group">
                        
                        <input type="date" id="joiningDate" class="form-control" name="joiningDate" placeholder="" value="{{old('joiningDate',$results[0]->Joining_date) }}" max="<?php echo date('Y-m-d'); ?>" required>
                        <label for="joiningDate">Joining Date<span style="color: red;">*</span></label>
                        <!-- <span class="error" id="joiningDateError"></span> -->
                    </div>
    
                   
                    <div class="form-group">
                       
                        <select id="reportingManager" class="form-control dropdown" name="reportingManager"  placeholder="" required>
                            <option value="{{ old('reportingManager',$results[0]->reporting_manager_id) }}">{{old('reportingManager',$results[0]->reporting_manager_name) }}</option>
                        @foreach($users as $user)

                        <option value="{{$user->id}}">{{$user->name}}</option>

                        @endforeach
                            ?>
                        </select>
                        <label for="reportingManager">Reporting Manager<span
                        style="color: red;">*</span></label>
                        <!-- <span class="error" id="reportingManagerError"></span> -->
                    </div>
    
    
    
                  
                    {{-- <div class="form-group">
                        
                        <input type="number" id="totalExperience" class="form-control" name="totalExperience"
                            placeholder="e.g., 6.2" value="{{ old('totalExperience',$results[0]->total_experience) }}"
                            title="Enter experience in the format Years.Months (e.g., 6.2), where months must be between 0 and 11."
                            required placeholder="">
                            <label for="totalExperience">
                            Total Experience (Format: Years.Months, e.g., 6.2 or 12.11) <span
                                style="color: red;">*</span>
                        </label>
                        <span class="error" id="totalExperienceError" style="color: red;"></span>
                    </div>
     --}}

     <div class="form-group">
        <input 
            type="number" 
            id="totalExperience" 
            class="form-control" 
            name="totalExperience" 
            placeholder="e.g., 6.2" 
            value="{{ old('totalExperience', $results[0]->total_experience) }}" 
            title="Enter experience in the format Years.Months (e.g., 6.2), where months must be between 0 and 11."
            required 
            step="any" 
          
            maxlength="5"
            pattern="^\d+(\.\d{1,2})?$" 
            oninput="validateExperience()">
        
        <label for="totalExperience">
            Total Experience (Format: Years.Months, e.g., 6.2 or 12.11) 
            <span style="color: red;">*</span>
        </label>
        
        <span class="error" id="totalExperienceError" style="color: red;"></span>
    </div>
    
    
                  
    
    
                </div>
            </div>
            <div class="address-form1">
                <div class="form-row1">
                    <div class="form-group">
                        
                        <select id="designation" class="form-control dropdown" name="designation" placeholder="" required>
                            <option value="{{ old('designation',$results[0]->designation_id) }}">{{ old('designation',$results[0]->role_name) }}</option>
                            @foreach($designations as $designation)
                            <option value="{{$designation->id}}">{{$designation->name}}</option>
                            @endforeach
                        </select>
                        <label for="designation">
                            Designation <span style="color: red;">*</span>
                        </label>
    
                        <!-- <span class="error" id="designationError"></span> -->
                    </div>
                                            <div class="form-group">
                    
                    <select id="department" class="form-control dropdown" name="department" placeholder="" required>
                        <option value="{{ old('department',$results[0]->department_id) }}">{{ old('department',$results[0]->department_name ) }}</option>
                        @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                         @endforeach
                    </select>
                    <label for="department">
                        Department <span style="color: red;">*</span>
                    </label>
    
                    <!-- <span class="error" id="departmentError"></span> -->
                </div>
    
    
                </div>
            </div>
        </div>
        <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
            <div class="address-form">
                <h3>Basic Details</h3>
                <div class="form-row">
                    <div class="form-group">
    
                       
                        <select id="gender" class="form-control dropdown" name="gender" placeholder="" required>
                            <option value="{{ old('gender',$results[0]->gender) }}">{{ old('gender',$results[0]->gender) }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="gender">Gender<span style="color: red;">*</span></label>
                        <!-- <span class="error" id="genderError"></span> -->
                    </div>
    
                    <div class="form-group">
                       
                        <input type="date" id="dateOfBirth" class="form-control" value="{{ old('dateOfBirth',$results[0]->date_of_birth) }}" name="dateOfBirth" placeholder=""  max="<?php echo date('Y-m-d'); ?>" required>
                        <label for="dateOfBirth">Date of Birth <span style="color: red;">*</span></label>
                        <!-- <span class="error" id="dateOfBirthError"></span> -->
                    </div>
    
                  
                    <div class="form-group">
                       
                        <select id="bloodGroup" class="form-control dropdown" name="bloodGroup" >
                            <option value="{{ old('bloodGroup',$results[0]->blood_group) }}">{{ old('bloodGroup',$results[0]->blood_group) }}</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                        <label for="bloodGroup">Blood Group</label>
                        <!-- <span class="error" id=" GroupError"></span> -->
                    </div>
                </div>
            </div>
            <div class="address-form">
                <div class="form-row">
                    <div class="form-group">
                        
                        <span class="error" id="nationalityError"></span>
                        <select id="nationality" class="form-control dropdown" name="nationality" placeholder="" required>
                            <option value="{{ old('nationality',$results[0]->nationality) }}" >{{ old('nationality',$results[0]->nationality) }}</option>
                           
                        </select>
                        <label for="nationality">Nationality <span style="color: red;">*</span></label>
                    </div>
    
    
                   
                    <div class="form-group">
                       {{-- //'Hinduism','Islam','Christianity','Sikhism','Buddhism','Jainism','Zoroastrianism','Judaism','Baha i Faith','Other' --}}
                        <select id="religion" class="form-control dropdown" name="religion" placeholder="" required>
                            <option value="{{ old('religion',$results[0]->religion) }}" disable Select> {{ old('religion', $results[0]->religion) }}</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Islam">Islam</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Sikhism">Sikhism</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Jainism">Jainism</option>
                            <option value="Zoroastrianism">Zoroastrianism</option>
                            <option value="Baha i Faith">Baha i Faith</option>
                            
                            <option value="Other">Other</option>
                           
                        </select>
                        <label for="religion">Religion <span style="color: red;">*</span></label>
                        <!-- <span class="error" id="religionError"></span> -->
                    </div>
    
    
                    <div class="form-group">
                        
                        <select id="maritalStatus" class="form-control dropdown" name="maritalStatus" required placeholder="">
                            <option value="{{ old('maritalStatus',$results[0]->marital_status) }}">{{ old('maritalStatus',$results[0]->marital_status) }}</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                        </select>
                        <label for="maritalStatus">Marital Status <span style="color: red;">*</span></label>
                        <span class="error" id="maritalStatusError"></span>
                    </div>
                </div>
            </div>
            <div class="address-form">
                <div class="form-row">
    
                    <div class="form-group">
                        
                        <input type="date" id="anniversaryDate" class="form-control" value="{{ old('anniversaryDate',$results[0]->anniversary_date) }}" name="anniversaryDate" placeholder=""
                             disabled>
                        <span class="error" id="anniversaryDateError" style="color: red;"></span>
                        <label for="anniversaryDate">Anniversary Date <span id="anniversaryRequiredMark"
                                style="color: red; display: none;">*</span></label>
                    </div>
    
                </div>
            </div>
        </div>
        <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
            <div class="address-form">
                <h3>Welfare Benefits</h3>
                <div class="form-row">
                    <div class="form-group">
                        
                        <input type="text" id="uan" name="uan" class="form-control"
                            placeholder="Enter Universal Account Number" minlength="12" value='{{old('uan',$results[0]->universal_account_number)}}' maxlength="16"
                            pattern="\d{12,16}" oninput="validateUAN(this)" placeholder=""
                            onkeypress="return isNumberKey(event)">
                            <label for="uan">Universal Account Number</label>
                        <span class="error" id="uanError"></span>
                    </div>
    
    
    
                    <div class="form-group">
                        
                        <input type="text" id="providentFund" class="form-control" name="providentFund" value="{{old('providentFund',$results[0]->provident_fund)}}"
                            placeholder="Enter Provident Fund" maxlength="18" pattern="[A-Za-z0-9]{1,18}" placeholder=""
                            oninput="this.value = this.value.toUpperCase()">
                        <span class="error" id="providentFundError"></span>
                        <label for="providentFund">Provident Fund</label>
                    </div>
    
    
    
                    <div class="form-group">
                        
                        <input type="text" id="esicNo" class="form-control" name="esicNo"
                            placeholder="Enter ESIC No" value="{{old('esicNo',$results[0]->esic_no)}}">
                        <span class="error" id="esicNoError"></span>
                        <label for="esicNo">ESIC No</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="button-container">
            <!-- <button class="previous-btn">Previous</button> 
            <button type="submit" class="next-btn">Next</button>
        </div> -->
        <div class="button-container">
            <!-- <button class="previous-btn">
                <span>&#8249;</span>
            </button> -->
            <button type="submit" class="next-btn">
                <span>&#8250;</span>
            </button>
        </div>
    
    
    </form>
    </div>
<script>

    const maritalStatusSelect = document.getElementById("maritalStatus");
    const anniversaryDateInput = document.getElementById("anniversaryDate");
    
    // Add an event listener to the marital status select dropdown
    maritalStatusSelect.addEventListener("change", function() {
        // Enable Anniversary_Date input for "Married" or "Divorced" options
        // console.log(maritalStatusSelect);
        if (maritalStatusSelect.value === "Married" || maritalStatusSelect.value === "Divorced") {
            anniversaryDateInput.disabled = false;  // Enable the date input
        } else {
            anniversaryDateInput.disabled = true;   // Disable the date input
            anniversaryDateInput.value = "";        // Clear the value when disabled
        }
    });
    
    
    // //     /**
    //                                  * Function to fetch nationalities from an API with retry logi                                  */
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

//Validation for total Experience
      function validateExperience() {
        var input = document.getElementById('totalExperience');
        var errorSpan = document.getElementById('totalExperienceError');
        var value = input.value.trim();
        var regex = /^(\d+(\.\d{1,2})?)$/; // Regular expression to match the format "years.months"

        // console.log(input);
        // console.log(errorSpan);
        // console.log(value);
        // console.log(regex);

        // console.log(value.length);
       

        if(value.length >= 6){
            input.disabled = true; 
        }

        if (regex.test(value)) {
            var parts = value.split('.');
            var years = parseInt(parts[0]);
            var months = parseInt(parts[1] || '0');

            // Check if months exceed 11, and convert to next year if so
            if (months >= 12) {
                years += Math.floor(months / 12); // Add the number of years equivalent to the months
                months = months % 12; // Keep only the remaining months (0-11)
                input.value = years + '.' + months; // Update the input with the new value
            }

            // Check if months are between 0 and 11
            if (months >= 0 && months <= 11) {
                errorSpan.textContent = ''; // Clear error if valid
            } else {
                errorSpan.textContent = 'Months must be between 0 and 11.';
            }
        } else {
            errorSpan.textContent = 'Please enter experience in the correct format (e.g., 6.2 or 12.11).';
        }
    }
     </script>
    <script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>
@endsection

{{-- <head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body> --}}

{{-- <nav class="navbar navbar-inverse">
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
</nav> --}}

{{-- <div class="container-fluid">

        
        <form action="{{ route('detail_insert') }}" method="POST">
            @csrf
            {{-- @foreach($results as $res) --}}
            
                {{-- <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Employee_Type</label>
                      <select class="form-control dropdown" name="emp_type" required>
                          <option value="">Select Employee Type</option>
                      @foreach($emp_types as $emp_type)
                  
                          <option value="{{$emp_type->id}}">{{$emp_type->name}}</option>
                
                      @endforeach
                      </select> --}}
                    {{-- </div>
                    <div class="col-xs-4">
                      <label for="ex2">Employee_No</label>
                      <input class="form-control" id="ex2" type="text" maxlength="20" name="employee_no"  value="" required placeholder="STPL0010">
                    </div>
                    <div class="col-xs-4">
                      <label for="ex3">Employee_Name</label>
                      <input class="form-control" id="ex3" type="text" placeholder="Enter Your Name" value="Employee Name" name="employee_name" required>
                    </div>
                  </div> --}}
              
                  {{-- <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Joining_Date</label>
                      <input class="form-control Joining_Date" id="Joining_Date" type="date" value="Joining Date" name="joining_date" required>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex2">Reporting_Manager</label>
                      <select class="form-control dropdown" name="reporting_manager" required>
                      <option value="">Reporting Manager</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
              </select>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex3">Total_Experience</label>
                      <input class="form-control" id="ex3" type="number" name="total_exp" value="" placeholder="Enter your Experience">
                    </div>
                  </div>
              
                  <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Designation</label>
                      <select class="form-control dropdown" name="designation" required>
                      <option value="">Designation</option>
                      @foreach($designations as $designation)
                      <option value="{{$designation->id}}">{{$designation->name}}</option>
                      @endforeach
              </select>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex2">Department</label>
                      <select class="form-control dropdown" name="department" required>
                      <option value="">Department</option>
                      @foreach($departments as $department)
                      <option value="{{$department->id}}">{{$department->name}}</option>
                      @endforeach
              </select>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex3">Gender</label>
                      <select class="form-control dropdown" name="gender" required>
                      <option value="">Gender</option>
                     
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="others">other</option>
              
              </select>
                    </div>
                  </div>
              
                  <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Date_Of_Birth</label>
                      <input class="form-control Joining_Date" id="ex1" value="" name="birth_date" type="date" required>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex2">Blood_Group</label>
                      <select class="form-control dropdown" name="blood_group" required>
                      <option value="">Select any one</option>
                     
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
                                                  <option value="" disabled selected></option>
                                              </select>
                    </div>
                  </div>
              
                  <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Religion</label>
                      <select class="form-control dropdown" name="religion" required>
                      <option value="">Select Any One</option>
                     
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
                      <option value="">Select Any One</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Divorced">Divorced</option>
              
              </select>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex3">Anniversary_Date</label>
                      <input class="form-control Joining_Date" id="anv" value='' name="anniversary_date" placeholder="Anniversary_Date" type="date" disabled>
                  
                    </div>
                  </div>
              
                  <div class="form-group row">
                    <div class="col-xs-4">
                      <label for="ex1">Universal_Account_Number</label>
                      <!-- <input class="form-control" id="ex1" type="number"> -->
                      <input class="form-control" id="ex1" type="text" pattern="\d{12}" maxlength="12" value="" name="uan" title="Please enter exactly 12 digits" placeholder="Please enter exactly 12 digits">
                    </div>
                    <div class="col-xs-4">
                      <label for="ex2">Provident_Fund</label>
                      <input class="form-control" id="ex2" type="text" maxlength="22" placeholder="PF" value="" name='pf'>
                    </div>
                    <div class="col-xs-4">
                      <label for="ex3">ESIC_No</label>
                      <input class="form-control" id="ex3" type="number"  maxlength="17" placeholder="ESIC_No" value="" name="esic">
                    </div>
                  </div>
              
                  <button type="submit" class="btn btn-success">Submit</button>
                  <a href="{{ route('user.contact') }}" class="btn btn-success">next</a>
              
                </form> --}}
              {{-- </div> --}}


  
   
<script>

// const today = new Date().toISOString().split('T')[0];  // Format YYYY-MM-DD

// // Select all date input fields with the class 'Joining_Date'
// const dateFields = document.getElementsByClassName("Joining_Date");

// // Loop through each date input field and set the 'max' attribute
// for (let i = 0; i < dateFields.length; i++) {
//     dateFields[i].setAttribute("max", today);
// }


// // Select the elements
// const maritalStatusSelect = document.getElementById("maritalStatus");
// const anniversaryDateInput = document.getElementById("anniversaryDate");

// // Add an event listener to the marital status select dropdown
// maritalStatusSelect.addEventListener("change", function() {
//     // Enable Anniversary_Date input for "Married" or "Divorced" options
//     console.log(maritalStatusSelect);
//     if (maritalStatusSelect.value === "Married" || maritalStatusSelect.value === "Divorced") {
//         anniversaryDateInput.disabled = false;  // Enable the date input
//     } else {
//         anniversaryDateInput.disabled = true;   // Disable the date input
//         anniversaryDateInput.value = "";        // Clear the value when disabled
//     }
// });


// // //     /**
// //                                  * Function to fetch nationalities from an API with retry logic.
// //                                  */
//                                 async function fetchNationalities(retries = 3) {
//                                     const selectElement = document.getElementById('nationality');

//                                     const fetchWithRetries = async () => {
//                                         try {
//                                             const response = await fetch('https://restcountries.com/v3.1/all', {
//                                                 headers: { "Content-Type": "application/json" },
//                                             });

//                                             if (!response.ok) {
//                                                 throw new Error('Network response was not ok');
//                                             }

//                                             const data = await response.json();
//                                             populateDropdown(data);
//                                         } catch (error) {
//                                             console.error("Error fetching nationalities: ", error);

//                                             if (retries > 0) {
//                                                 console.log('Retrying fetch...');
//                                                 setTimeout(() => fetchWithRetries(retries - 1), 1000);
//                                             } else {
//                                                 alert("Unable to load nationalities after multiple attempts.");
//                                             }
//                                         }
//                                     };

//                                     const populateDropdown = (countries) => {
//                                         const sortedCountries = countries.sort((a, b) =>
//                                             a.name?.common?.localeCompare(b.name?.common)
//                                         );

//                                         selectElement.innerHTML = ""; // Clear dropdown before appending data
//                                         sortedCountries.forEach(country => {
//                                             const option = document.createElement('option');
//                                             option.value = country.name?.common?.toLowerCase() || '';
//                                             option.textContent = country.name?.common || 'Unknown';
//                                             selectElement.appendChild(option);
//                                         });

//                                         // Set default nationality to India if available
//                                         const indiaOption = Array.from(selectElement.options).find(option => option.value === "india");
//                                         if (indiaOption) {
//                                             indiaOption.selected = true;
//                                         }
//                                     };

//                                     // Call the fetch with retry
//                                     fetchWithRetries();
//                                 }

//                                 // Wait for DOM to load and execute the function
//                                 document.addEventListener("DOMContentLoaded", function () {
//                                     fetchNationalities();
//                                 });



//                                 window.onload = function() {
//     // Get all the select elements
//     const dropdowns = document.querySelectorAll('.dropdown');
    
//     dropdowns.forEach(dropdown => {
//       const selectedValue = dropdown.value;

//       // Loop through each dropdown's options and hide the selected one
//       for (let option of dropdown.options) {
//         if (option.value === selectedValue) {
//           option.style.display = 'none';  // Hide the selected option
//           break; // Only hide the selected option
//         }
//       }
//     });
//   };





// //     </script>
</body>

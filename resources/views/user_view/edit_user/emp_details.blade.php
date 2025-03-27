@include('user_view.header')
@extends('user_view/edit_user/employee_form_layout')  <!-- Extending the layout file -->

@section('content')  <!-- Defining the content section -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
error_reporting(0);
$permission_array = session('id');
// $id = Auth::guard('web')->user()->id;
// $name = Auth::guard('web')->user()->name;
// $employeeID = Auth::guard('web')->user()->employeeID;


$editUser = $_REQUEST['id'];
// dd($results);


// dd($results);

?>
{{-- 
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
    @endif --}}

    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
    @foreach($errors->all() as $error)
        <li style="color: red;">{{ $error }}</li>
    @endforeach
</ul>
@endif


<div class="tab-content active" id="tab1">

    <form action="{{ route('edit_detail_insert') }}" method="POST">
        @csrf
        <input type="hidden" name="form_step" value="form_step">
        <!-- Hidden input to identify the step -->
        <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
            <div class="address-form">
                <h3>Employee Details</h3>
                <div class="form-row">
                    <div class="form-group">
                        <select id="employmentType" class="form-control dropdown" name="employmentType" placeholder="" required>
                            <option value="{{ old('employmentType', $results[0]->employee_type) }}">{{ old('employmentType', $results[0]->employee_type_name) }}</option>
                            @foreach($emp_types as $emp_type)
                            <option value="{{$emp_type->id}}">{{$emp_type->name}}</option>
                            @endforeach
                        </select>
                        <label for="employmentType">Employment Type<span style="color: red;">*</span></label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="employeeNo" class="form-control" name="employeeNo" value="{{$loginUserInfo->employeeID}}" readonly placeholder="" required>
                        <label for="employeeNo">Employee No</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="employeeName" class="form-control" name="employeeName" value="{{$loginUserInfo->name}}" readonly required placeholder="">
                        <label for="employeeName">Employee Name</label>
                    </div>
                    <div class="form-group">
                        <input type="date" id="joiningDate" class="form-control" name="joiningDate" placeholder="" value="{{old('joiningDate',$results[0]->Joining_date) }}" max="<?php echo date('Y-m-d'); ?>" required>
                        <label for="joiningDate">Joining Date<span style="color: red;">*</span></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <select id="reportingManager" class="form-control dropdown" name="reportingManager" placeholder="" required>
                            <option value="{{ old('reportingManager',$results[0]->reporting_manager_id) }}">{{old('reportingManager',$results[0]->reporting_manager_name) }}</option>
                            <!-- <option value="None"></option> -->
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        <label for="reportingManager">Reporting Manager<span style="color: red;">*</span></label>
                    </div>
                    <div class="form-group">
                        <input type="number" id="totalExperience" class="form-control" name="totalExperience" placeholder="e.g., 6.2" value="{{ old('totalExperience', $results[0]->total_experience) }}" title="Enter experience in the format Years.Months (e.g., 6.2), where months must be between 0 and 11." required step="any" maxlength="5" pattern="^\d+(\.\d{1,2})?$" oninput="validateExperience()">
                        <label for="totalExperience">Total Experience(Years.Month)<span style="color: red;">*</span></label>
                        <span class="error" id="totalExperienceError" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <select id="branch" class="form-control dropdown" name="branch" placeholder="" required>
                            <option value="{{ old('branch',$results[0]->branch_id) }}">{{ old('branch',$results[0]->branch_name) }}</option>
                            @foreach($branches as $branche)
                            <option value="{{$branche->id}}">{{$branche->name}}</option>
                            @endforeach
                        </select>
                        <label for="designation">Branch <span style="color: red;">*</span></label>
                    </div>
                    
                    <div class="form-group">
                        <select id="department" class="form-control dropdown" name="department" placeholder="" required>
                            <option value="{{ old('department',$results[0]->department_id) }}">{{ old('department',$results[0]->department_name ) }}</option>
                            
                        </select>
                        <label for="department">Department <span style="color: red;">*</span></label>
                    </div>
                  


                    <div class="form-group">
                        <select id="designation" class="form-control dropdown" name="designation" placeholder="" required>
                            <option value="{{ old('designation',$results[0]->designation_id) }}">{{ old('designation',$results[0]->role_name) }}</option>
                        
                        </select>
                        <label for="designation">Designation <span style="color: red;">*</span></label>
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
                    </div>
                    <div class="form-group">
                        <input type="date" id="dateOfBirth" class="form-control" value="{{ old('dateOfBirth',$results[0]->date_of_birth) }}" name="dateOfBirth" placeholder="" max="<?php echo date('Y-m-d'); ?>" required>
                        <label for="dateOfBirth">Date of Birth <span style="color: red;">*</span></label>
                    </div>
                    <div class="form-group">
                        <select id="bloodGroup" class="form-control dropdown" name="bloodGroup">
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
                    </div>
                    <div class="form-group">
                        <select id="nationality" class="form-control dropdown" name="nationality" placeholder="" required>
                            <option value="{{ old('nationality',$results[0]->nationality) }}">{{ old('nationality',$results[0]->nationality) }}</option>
                        </select>
                        <label for="nationality">Nationality <span style="color: red;">*</span></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <select id="maritalStatus" class="form-control dropdown" name="maritalStatus" required placeholder="">
                            <option value="{{ old('maritalStatus',$results[0]->marital_status) }}">{{ old('maritalStatus',$results[0]->marital_status) }}</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            
                        </select>
                        <label for="maritalStatus">Marital Status <span style="color: red;">*</span></label>
                        <span class="error" id="maritalStatusError"></span>
                    </div>
                    <div class="form-group">
                        <input type="date" id="anniversaryDate" class="form-control" value="{{ old('anniversaryDate',$results[0]->anniversary_date) }}" name="anniversaryDate" placeholder="" max="{{ \Carbon\Carbon::now()->toDateString() }}" disabled>
                        <span class="error" id="anniversaryDateError" style="color: red;"></span>
                        <label for="anniversaryDate">Anniversary Date <span id="anniversaryRequiredMark" style="color: red; display: none;">*</span></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="column" style="flex: 1; border: 1px solid #ba184e; padding: 20px; border-radius: 8px;">
            <div class="address-form">
                <h3>Welfare Benefits</h3>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="uan" name="uan" class="form-control" placeholder="Enter Universal Account Number" minlength="12" value='{{old('uan',$results[0]->universal_account_number)}}' maxlength="16" pattern="\d{12,16}" oninput="validateUAN(this)" placeholder="" onkeypress="return isNumberKey(event)">
                        <label for="uan">Universal Account Number</label>
                        <span class="error" id="uanError"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="providentFund" class="form-control" name="providentFund" value="{{old('providentFund',$results[0]->provident_fund)}}" placeholder="Enter Provident Fund" maxlength="18" pattern="[A-Za-z0-9]{1,18}" placeholder="" oninput="this.value = this.value.toUpperCase()">
                        <span class="error" id="providentFundError"></span>
                        <label for="providentFund">Provident Fund</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="esicNo" class="form-control" name="esicNo" placeholder="Enter ESIC No" maxlength="17" value="{{old('esicNo',$results[0]->esic_no)}}" oninput="this.value = this.value.toUpperCase()">
                        <span class="error" id="esicNoError"></span>
                        <label for="esicNo">ESIC No</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-container">
            <button type="submit" class="next-btn">
                <span>&#8250;</span>
            </button>
        </div>
    </form>
</div>

<script>
    
$(document).ready(function () {
    //For load leave according to the leave policy and taken leaves
            $('#branch').on('change',function () {
                // Create data to send with the request
             var branch_id = $(this).val();
        
    $.ajax({
    url: '/user/edit/fetch_department/' + branch_id, // Send branch_id in the URL
    type: 'get',
    success: function (response) {
        // On success, update the department dropdown
        var $departmentSelect = $('#department');
        $departmentSelect.empty(); // Clear existing options

        // Add the default option (if needed)
        $departmentSelect.append('<option value="" disabled>Select Department</option>');

        // Iterate over the response to add options dynamically
        $.each(response, function (index, department) {
            $departmentSelect.append('<option value="' + department.department_id + '">' + department.department_name + '</option>');
        });
    },
    error: function (xhr, status, error) {
        // Handle error
        $('#response').html('Error: ' + error);
    },
    dataType: 'json', // Expect a JSON response
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
});

           $('#department').on('change',function () {
                // Create data to send with the request
             
             var department_id = $(this).val();
              
            //  console.log(designation_id);

         var url = '/user/edit/fetch_designation/' + department_id;

         console.log(url);

                     // Perform the AJAX request
                     $.ajax({
                  
                  url: url,
                  type: 'get',
                  success: function (response) {
        
        var $designationSelect = $('#designation');
        $designationSelect.empty(); // Clear existing options

        // Add the default option (if needed)
        $designationSelect.append('<option value="" disabled>Select Designation</option>');

        // Iterate over the response to add options dynamically
        $.each(response, function (index, designation) {
            $designationSelect.append('<option value="' + designation.id + '">' + designation.name + '</option>');
        });
    },
    error: function (xhr, status, error) {
        // Handle error
        $('#response').html('Error: ' + error);
    },
    dataType: 'json', // Expect a JSON response
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
              });


        
            });

        }); 

    const maritalStatusSelect = document.getElementById("maritalStatus");
    const anniversaryDateInput = document.getElementById("anniversaryDate");
    const anniversaryRequiredMark = document.getElementById("anniversaryRequiredMark");
    const form = document.querySelector("form");

    maritalStatusSelect.addEventListener("change", function() {
        if (maritalStatusSelect.value === "Married") {
            anniversaryDateInput.disabled = false;
            anniversaryDateInput.required = true;
            anniversaryRequiredMark.style.display = 'inline';
        } else {
            anniversaryDateInput.disabled = true;
            anniversaryDateInput.required = false;
            anniversaryDateInput.value = "";
            anniversaryRequiredMark.style.display = 'none';
        }
    });

    maritalStatusSelect.dispatchEvent(new Event('change'));

    form.addEventListener("submit", function(event) {
        if (maritalStatusSelect.value === "Married" && !anniversaryDateInput.value) {
            event.preventDefault();
            alert("Please enter your anniversary date.");
        }
    });

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

            const indiaOption = Array.from(selectElement.options).find(option => option.value === "india");
            if (indiaOption) {
                indiaOption.selected = true;
            }
        };

        fetchWithRetries();
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchNationalities();
    });

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

    function validateExperience() {
        var input = document.getElementById('totalExperience');
        var errorSpan = document.getElementById('totalExperienceError');
        var value = input.value.trim();
        var regex = /^(\d+(\.\d{1,2})?)$/;

        if(value.length >= 6){
            input.value = '';
        }

        if (regex.test(value)) {
            var parts = value.split('.');
            var years = parseInt(parts[0]);
            var months = parseInt(parts[1] || '0');

            if (months >= 12) {
                years += Math.floor(months / 12);
                months = months % 12;
                input.value = years + '.' + months;
            }

            if (months >= 0 && months <= 11) {
                errorSpan.textContent = '';
            } else {
                errorSpan.textContent = 'Months must be between 0 and 11.';
            }
        } else {
            errorSpan.textContent = 'Please enter experience in the correct format (e.g., 6.2 or 12.11).';
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<script src="{{ asset('user_end/js/onboarding_form.js') }}"></script>

@endsection
</body>

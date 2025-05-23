<!DOCTYPE html>
@extends('user_view.header')
@section('content')

<head>
<link rel="stylesheet" href="{{ asset('/user_end/css/setting.css') }}">
<link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    
    <link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
</head>
 

<main class="settings-container">
    <?php $permission_array = session('permission_array'); ?>

    @if($errors->any())
    <div class="alert custom-alert-warning">
        <ul>
            @foreach($errors->all() as $error)
            <li style="color: red;">{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
        <h2>Settings</h2>
        <div class="accordion">
            <!-- Upcoming Holidays -->
            <?php 
                if(in_array(11, $permission_array)){ 
                ?>
                    <div class="accordion-item my-2">
                        <!-- Accordion Header with a toggle dropdown -->
                        <div class="accordion-header" onclick="toggleCalendarMasterDropdown()">
                            Calendar Master
                        </div>

                        <!-- Dropdown content (initially hidden) -->
                        <div id="calendarMasterDropdown" class="dropdown-content px-3" style="display: none;">
                            <form id="calendarMasterForm" method="POST" action="{{ route('create_calendra_master') }}">
                                @csrf
                                <div class="row">
                                    <!-- Year Selection -->
                                     <div class="col-4">
                                        <div class="form-group">
                                            <label for="year">Select Year:</label>
                                            <select id="year" name="year">
                                                <option value="">--Select Year--</option>
                                            </select>
                                            <span class="error" id="yearError"></span>
                                        </div>
                                     </div>

                                    <!-- Type of Selection (Week Off / Holiday) -->
                                     <div class="col-4">
                                        <div class="form-group">
                                            <label for="weekOffHolidaySelect">Select Type:</label>
                                            <select id="weekOffHolidaySelect" name="weekOffHolidaySelect">
                                                <option value="">--Select--</option>
                                                <option value="weekoff">Week Off</option>
                                                <option value="holiday">Holiday</option>
                                            </select>
                                            <span class="error" id="typeError"></span>
                                        </div>
                                     </div>
                                </div>
                                <!-- Week Off Selection (checkboxes) -->
                                <div id="weekOffSelection" style="display:none;"> 
                                    <div class="row mx-2">
                                        <div class="col-3 my-1"><input type="checkbox" id="sunday" name="weekoff[]" value="0"> Sunday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="monday" name="weekoff[]" value="1"> Monday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="tuesday" name="weekoff[]" value="2"> Tuesday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="wednesday" name="weekoff[]" value="3"> Wednesday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="thursday" name="weekoff[]" value="4"> Thursday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="friday" name="weekoff[]" value="5"> Friday</div>
                                        <div class="col-3 my-1"><input type="checkbox" id="saturday" name="weekoff[]" value="6"> Saturday</div>
                                    </div> 
                                    <span class="error" id="weekOffError"></span>
                                </div>

                                <!-- Holiday Selection (Date, Name, and Description) -->
                                <div id="holidayUpdate" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-4 my-2">                                                                
                                            <div class="form-group">
                                                <label for="holiday_date">Holiday Date</label>
                                                <input type="date" id="holiday_date" name="holiday_date">
                                                <span class="error" id="holidayDateError"></span><br><br>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">                                        
                                            <div class="form-group">
                                                <label for="holiday_name">Holiday Name</label>
                                                <input type="text" maxlength="200" id="holiday_name" name="holiday_name">
                                                <span class="error" id="holidayNameError"></span><br><br>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">                                        
                                            <div class="form-group">
                                                <label for="holiday_desc">Holiday Description</label>
                                                <textarea id="holiday_desc" maxlength="200" name="holiday_desc"></textarea>
                                                <span class="error" id="holidayDescError"></span>
                                            </div>
                                        </div>

                                </div>
                                </div>

                                <!-- Working Hours Container (Dynamically populated) -->
                                <div id="workingHoursContainer" style="display:none;">
                                    <!-- Working hours will be dynamically inserted here -->
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="submit-btn px-3 py-1">Submit</button>
                            </form>
                        </div>
                    </div>
                <?php 
                }
                ?>


            <!-- Leave Section (With Link to hr_universal.php) -->
            <!-- {{-- <div class="accordion-item my-2">
                <div class="accordion-header" onclick="window.location.href='{{ url('hr_universal') }}'">
                    Global Leaves
                </div>
            </div> --}} -->

            <!-- Thought of the Day -->
            <?php 
            if(in_array(13,$permission_array)){?>
             
                <div class="accordion-item my-2">
                    <div class="accordion-header" onclick="toggleDropdown()">Thought of the Day/News & Events</div>
                    <div class="dropdown-content" id="dropdownContent">
                        <form action="{{ route('save_thought') }}" method="POST">
                            @csrf
                            <!-- Entry Type -->
                            <!-- <div class="form-group"> --> 
                                <div class="radio-group">
                                    <div class="col-4 my-1">
                                        <div class="form-group">
                                            <input type="radio" name="entryType" value="thought" checked onclick="switchForm('thought')"> Thought of the Day
                                        </div>
                                    </div>
                                    <div class="col-4 my-1">
                                        <div class="form-group">
                                            <input type="radio" name="entryType" value="news" onclick="switchForm('news')"> News & Events
                                        </div>
                                    </div>
                                </div>
                            <!-- </div> -->
                        </form>

                        <!-- Thought of the Day Form -->
                        <div id="thoughtForm" class="dynamic-form active">
                            <form action="{{ route('save_thought') }}" method="POST">
                                @csrf
                                <input type="hidden" name="entryType" value="thought">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="entryDate">Date:</label> 
                                            <input type="date" id="thoughtDate" name="date" placeholder="DD/MM/YYYY"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="thoughtDescription">Thought of the day :</label>
                                            <textarea id="thoughtDescription" maxlength="200" name="description" placeholder="Thought of the day"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="submit-btn" id="submitThought" disabled>Submit</button>
                            </form>
                        </div>

                        <!-- News & Events Form -->
                        <div id="newsForm" class="dynamic-form">
                            <form action="{{ route('save_news_events') }}" method="POST">
                                @csrf
                                <input type="hidden" name="entryType" value="news">
                                <div class="row">

                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="entryDate">Date:</label> 
                                                <input type="date" id="date" name="date" placeholder="DD/MM/YYYY"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="title">Title :</label>
                                            <input type="text" id="title" maxlength="60" name="title" placeholder="News or event title">
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="description">Description :</label>
                                            <textarea id="description" maxlength="200" name="description" placeholder="Detailed information about the news or event"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="event-start-date">Event Start Date:</label> 
                                            <input type="date" id="event-start-date" name="startdate" placeholder="Select Start Date"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="event-end-date">Event End Date:</label> 
                                            <input type="date" id="event-end-date" name="enddate" placeholder="Select End Date"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <div class="form-group">
                                            <label for="location">Location :</label>
                                            <input type="text" id="location" maxlength="200" name="location" placeholder="Optional, e.g., 'City Hall'">
                                        </div>
                                    </div> 
                                </div>
                                <button type="submit" class="submit-btn px-3 py-1" id="submitNews" disabled>Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                
            <?php
            }
            
            
            
            ?>
         
            <!-- Employee Edit -->
            <?php 
                if(in_array(12, $permission_array)){ 
                ?>
            <div class="accordion-item my-2">
                <!-- Accordion Header with a toggle dropdown -->
                <div class="accordion-header" onclick="toggleEmployeeDetailsDropdown()">
                    Employee Details Edit
                </div>

                <!-- Dropdown content (initially hidden) -->
                <div id="employeeDetailsDropdown" class="dropdown-content" style="display: none;">
                    <!-- Collapsible Content (Table) -->
                    <div class="content">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a type="button" href="{{ route('user.editdashboard',['id' => $user->id]) }}" class="text-secondary">
                                               <x-icon name="edit" />
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php 
                //user salary functions
                if(in_array(14, $permission_array)){ 
                ?>
                    <div class="accordion-item my-2">
                        <!-- Accordion Header with a toggle dropdown -->
                        <div class="accordion-header" onclick="toggleEmployeeSalaryDropdown()">
                            Employee Salary
                        </div>
                
                        <!-- Dropdown content (initially hidden) -->
                        <div id="EmployeeSalaryDropdown" class="dropdown-content" style="display: none;">
                            <!-- Collapsible Content (Table) -->
                            <div class="content">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Salary Template</th>
                                            <th>Employee CTC</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        @foreach ($users_for_salary as $us)
                                        <form action="{{ route('user.salaryTemCTC') }}" method="POST">
                                            @csrf
                                            <tr>
                                                <input type="hidden" name="user_id" value="{{ $us->user_id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $us->emp_employeeID }}</td>
                                                <td>{{ $us->user_name }}</td>
                                                <td>
                                                    <select name="trmplate_id" required>
                                                        <option value="{{ $us->org_salary_templates_id }}">{{ $us->org_salary_templates_name }}</option>
                                                        @foreach ($salary_templates as $st)
                                                        <option value="{{$st->id}}">{{$st->name}}</option>
                                                        @endforeach
                                                    
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="ctc" value="{{$us->user_ctc}}">
                                                </td>
                                                <td>
            
                                                        <input type="submit" value="submit">
                                                    
                                                </td>
                                            </tr>
                                        </form>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{-- {{ $users_for_salary->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
            </div>
                <div class="accordion-item my-2">
                    <!-- Accordion Header with a toggle dropdown -->
                    <div class="accordion-header" onclick="toggleProcessSalaryDropdown()">
                        Process Salary (2025-26)
                    </div>
            
                    <!-- Dropdown content (initially hidden) -->
                    <div id="ProcessSalaryDropdown" class="dropdown-content mt-0 pt-0" style="display: none;">
                        <!-- Collapsible Content (Table) -->
                        <form action="{{ route('process_salary') }}" method="POST" >
                            @csrf
                            <div class="row">
                            
                                <div class="col-md-3 my-2">                                            
                                    <div class="form-group">
                                        <div class="floating-label-wrapper w-100">
                                            <label>Cycle Year</label>
                                            <input class="form-control" type="hidden" value="{{ $dataofcurrentyear->id }}" name="cycle_id">
                                            <input type="text" value="{{ $dataofcurrentyear->name }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2">                                                        
                                    <div class="form-group">
                                        <div class="floating-label-wrapper w-100">
                                            <label>Salary Month</label>
                                            <select class="form-control" name="selected_month">
                                            <option value="">Select Month</option>
                                            @foreach ($monthsInCycle as $MC)
                                                <option value="{{ $MC  }}">{{ $MC  }}</option>                        
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        <button class="ms-auto px-4 py-1" type="submit">Process</button>
                        </form>
                    </div>
                </div>      
        </div>



<!-- Leave Summary Section -->
<div class="accordion-item my-2">
    <div class="accordion-header" onclick="#">
        Leave Summary
    </div>
    <div id="LeaveSummaryDropdown" class="dropdown-content mt-0 pt-0" style="display: block;">
    <div class="accordion-content">
        {{-- Month & Year Filter --}}
            <form method="GET" action="{{ route('user.setting') }}" class="mb-3 d-flex align-items-center gap-2">
                <select name="leave_type_id" id="leave_type_id" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach ($leaveTypes as $type)
                        <option value="{{ $type->id }}" {{ $type->id == request('leave_type_id') ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                   <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()">
                    
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()">
            </form>     
        <!-- Leave Summary Table -->
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Leave Type</th>
                        <th>Opening Days</th>
                        <th>Credited Days</th>
                        <th>Approved Days</th>
                        <th>Pending for Approval</th>                    
                        <th>Total Leave Remaining</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Initialize summary totals
                        $totalApproved = 0;
                        $totalPending = 0;
                        $totalCarryForward = 0;
                        $totalRemaining = 0;
                        $totalMaxLeave = 0;
                    @endphp
                    
                    @foreach ($leaveSummary as $leave)
                        <tr>
                            <td>{{ $leave->employee_name }}</td>
                            <td>{{ $leave->employeeID }}</td>
                            <td>{{ $leave->leave_type_name }}</td>
                             <td>{{ $leave->total_carry_forward }}</td>
                             <td>{{ $leave->max_leave }}</td> 
                            <td>{{ $leave->approved_days }}</td>
                            <td>{{ $leave->pending_days }}</td>                   
                            <td>{{ $leave->total_leave_remaining }}</td>
                        </tr>

                        @php
                            // Add to summary totals
                            $totalApproved += $leave->approved_days;
                            $totalPending += $leave->pending_days;
                            $totalCarryForward += $leave->total_carry_forward;
                            $totalRemaining += $leave->total_leave_remaining;
                             $totalMaxLeave += $leave->max_leave; // New Total
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>{{ $totalCarryForward }}</th>
                        <th>{{ $totalMaxLeave }}</th>
                        <th>{{ $totalApproved }}</th>
                        <th>{{ $totalPending }}</th>                  
                        <th>{{ $totalRemaining }}</th>
                    </tr>
                </tfoot>
            </table>             
    </div>
</div>
</main>

<script>
    function toggleEmployeeDetailsDropdown() {
        var dropdown = document.getElementById("employeeDetailsDropdown");
        dropdown.style.display = dropdown.style.display === "none" || dropdown.style.display === "" ? "block" : "none";
    }

    function toggleCalendarMasterDropdown() {
        var dropdown = document.getElementById("calendarMasterDropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }

    function toggleEmployeeSalaryDropdown() {
        var dropdown = document.getElementById("EmployeeSalaryDropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }

     function toggleProcessSalaryDropdown() {
        var dropdown = document.getElementById("ProcessSalaryDropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }

     function toggleLeaveSummaryDropdown() {
        var dropdown = document.getElementById("LeaveSummaryDropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }

    document.addEventListener("DOMContentLoaded", function () {
        const yearSelect = document.getElementById("year");
        const weekOffHolidaySelect = document.getElementById("weekOffHolidaySelect");
        const weekOffSelection = document.getElementById("weekOffSelection");
        const holidayUpdate = document.getElementById("holidayUpdate");
        const workingHoursContainer = document.getElementById("workingHoursContainer");

        weekOffSelection.style.display = "none";
        holidayUpdate.style.display = "none";
        workingHoursContainer.style.display = "none";

        weekOffHolidaySelect.addEventListener("change", function () {
            const selectedOption = weekOffHolidaySelect.value;
            if (selectedOption === "weekoff") {
                weekOffSelection.style.display = "block";
                holidayUpdate.style.display = "none";
                workingHoursContainer.style.display = "block";
            } else if (selectedOption === "holiday") {
                weekOffSelection.style.display = "none";
                holidayUpdate.style.display = "block";
                workingHoursContainer.style.display = "none";
            }
        });

        function populateYearDropdown() {
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year <= currentYear + 50; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }
        }

        populateYearDropdown();

        const weekOffCheckboxes = document.querySelectorAll('input[name="weekoff[]"]');
        weekOffCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateWorkingHoursFields();
            });
        });

        function updateWorkingHoursFields() {
            const weekOffDays = [];
            workingHoursContainer.innerHTML = "";
            weekOffCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    weekOffDays.push(checkbox.value);
                }
            });

            const allDays = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
            const workingDays = allDays.filter(day => !weekOffDays.includes(day));

            if (workingDays.length > 0) {
                workingHoursContainer.innerHTML = `
                    <div class='row '>
                        <div class="col-md-4">
                         <div class="form-group">
                        <label>Set Working Hours for All Working Days:</label><br>
                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="working_start_time"><br>
                        </div></div>
                        <div class="col-md-4">
                         <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="working_end_time"><br>
                        </div></div>
                    </div>
                `;
            } else {
                workingHoursContainer.innerHTML = "<p>No working days left. Please select week off days first.</p>";
            }
        }
    });

    function toggleDropdown() {
        const dropdownContent = document.getElementById("dropdownContent");
        dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
    }

    document.getElementById("thoughtDate").addEventListener("input", validateThoughtForm);
    document.getElementById("thoughtDescription").addEventListener("input", validateThoughtForm);

    function validateThoughtForm() {
        const thoughtDate = document.getElementById("thoughtDate").value;
        const thoughtDescription = document.getElementById("thoughtDescription").value;
        const submitButton = document.getElementById("submitThought");

        submitButton.disabled = !(thoughtDate && thoughtDescription);
    }

    document.getElementById("date").addEventListener("input", validateNewsForm);
    document.getElementById("title").addEventListener("input", validateNewsForm);
    document.getElementById("description").addEventListener("input", validateNewsForm);
    document.getElementById("event-start-date").addEventListener("input", validateNewsForm);
    document.getElementById("event-end-date").addEventListener("input", validateNewsForm);
    document.getElementById("location").addEventListener("input", validateNewsForm);

    function validateNewsForm() {
        const date = document.getElementById("date").value;
        const title = document.getElementById("title").value;
        const description = document.getElementById("description").value;
        const eventStartDate = document.getElementById("event-start-date").value;
        const eventEndDate = document.getElementById("event-end-date").value;
        const location = document.getElementById("location").value;
        const submitButton = document.getElementById("submitNews");

        submitButton.disabled = !(date && title && description && eventStartDate && eventEndDate && location);
    }

    function switchForm(formType) {
        const thoughtForm = document.getElementById("thoughtForm");
        const newsForm = document.getElementById("newsForm");

        if (formType === "thought") {
            thoughtForm.style.display = "block";
            newsForm.style.display = "none";
        } else if (formType === "news") {
            thoughtForm.style.display = "none";
            newsForm.style.display = "block";
        }
    }
</script>

@endsection

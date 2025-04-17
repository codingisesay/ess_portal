<!DOCTYPE html>
@extends('user_view.header')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('/user_end/css/setting.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    
</head>

<style>
  .content {
      padding: 0 18px;
      display: block;
      overflow-y: auto;
      background-color: #ffffff;
  }
</style>

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
        <h1>Settings</h1>
        <div class="accordion">
            <!-- Upcoming Holidays -->
            <?php 
if(in_array(11, $permission_array)){ 
?>
    <div class="accordion-item">
        <!-- Accordion Header with a toggle dropdown -->
        <div class="accordion-header" onclick="toggleCalendarMasterDropdown()">
            Calendar Master
        </div>

        <!-- Dropdown content (initially hidden) -->
        <div id="calendarMasterDropdown" class="dropdown-content" style="display: none;">
            <form id="calendarMasterForm" method="POST" action="{{ route('create_calendra_master') }}">
                @csrf
                <!-- Year Selection -->
                <div class="form-group">
                    <label for="year">Select Year:</label>
                    <select id="year" name="year">
                        <option value="">--Select Year--</option>
                    </select>
                    <span class="error" id="yearError"></span>
                </div>

                <!-- Type of Selection (Week Off / Holiday) -->
                <div class="form-group">
                    <label for="weekOffHolidaySelect">Select Type:</label>
                    <select id="weekOffHolidaySelect" name="weekOffHolidaySelect">
                        <option value="">--Select--</option>
                        <option value="weekoff">Week Off</option>
                        <option value="holiday">Holiday</option>
                    </select>
                    <span class="error" id="typeError"></span>
                </div>

                <!-- Week Off Selection (checkboxes) -->
                <div id="weekOffSelection" style="display:none;">
                    <div class="form-group">
                        <!-- <label></label><br> -->
                        <div class="checkbox-grid">
                            <div><input type="checkbox" id="sunday" name="weekoff[]" value="0"> Sunday</div>
                            <div><input type="checkbox" id="monday" name="weekoff[]" value="1"> Monday</div>
                            <div><input type="checkbox" id="tuesday" name="weekoff[]" value="2"> Tuesday</div>
                            <div><input type="checkbox" id="wednesday" name="weekoff[]" value="3"> Wednesday</div>
                            <div><input type="checkbox" id="thursday" name="weekoff[]" value="4"> Thursday</div>
                            <div><input type="checkbox" id="friday" name="weekoff[]" value="5"> Friday</div>
                            <div><input type="checkbox" id="saturday" name="weekoff[]" value="6"> Saturday</div>
                        </div>
                    </div>
                    <span class="error" id="weekOffError"></span>
                </div>

                <!-- Holiday Selection (Date, Name, and Description) -->
                <div id="holidayUpdate" style="display:none;">
                    <div class="form-group">
                        <label for="holiday_date">Holiday Date:</label>
                        <input type="date" id="holiday_date" name="holiday_date">
                        <span class="error" id="holidayDateError"></span><br><br>
                    </div>

                    <div class="form-group">
                        <label for="holiday_name">Holiday Name:</label>
                        <input type="text" maxlength="200" id="holiday_name" name="holiday_name">
                        <span class="error" id="holidayNameError"></span><br><br>
                    </div>

                    <div class="form-group">
                        <label for="holiday_desc">Holiday Description:</label>
                        <textarea id="holiday_desc" maxlength="200" name="holiday_desc"></textarea>
                        <span class="error" id="holidayDescError"></span>
                    </div>
                </div>

                <!-- Working Hours Container (Dynamically populated) -->
                <div id="workingHoursContainer" style="display:none;">
                    <!-- Working hours will be dynamically inserted here -->
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
<?php 
}
?>


            <!-- Leave Section (With Link to hr_universal.php) -->
            {{-- <div class="accordion-item">
                <div class="accordion-header" onclick="window.location.href='{{ url('hr_universal') }}'">
                    Global Leaves
                </div>
            </div> --}}

            <!-- Thought of the Day -->
            <?php 
            if(in_array(13,$permission_array)){?>
            
            
            
            <div class="accordion-item">
                <div class="accordion-header" onclick="toggleDropdown()">Thought of the Day/News & Events</div>
                <div class="dropdown-content" id="dropdownContent">
                    <form action="{{ route('save_thought') }}" method="POST">
                        @csrf
                        <!-- Entry Type -->
                        <div class="form-group">
                            <label>Entry Type :</label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="entryType" value="thought" checked onclick="switchForm('thought')"> Thought of the Day
                                </label>
                                <label>
                                    <input type="radio" name="entryType" value="news" onclick="switchForm('news')"> News & Events
                                </label>
                            </div>
                        </div>
                    </form>

                    <!-- Thought of the Day Form -->
                    <div id="thoughtForm" class="dynamic-form active">
                        <form action="{{ route('save_thought') }}" method="POST">
                            @csrf
                            <input type="hidden" name="entryType" value="thought">
                            <div class="form-group">
                                <label for="entryDate">Date:</label>
                                <div class="input-with-icon">
                                    <input type="date" id="thoughtDate" name="date" placeholder="DD/MM/YYYY">
                                    <!-- <img src="{{ asset('resource/image/setting/calendar (4) 1.png') }}" alt="Calendar" class="calendar-icon" /> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="thoughtDescription">Thought of the day :</label>
                                <textarea id="thoughtDescription" maxlength="200" name="description" placeholder="Thought of the day"></textarea>
                            </div>
                            <button type="submit" class="submit-btn" id="submitThought" disabled>Submit</button>
                        </form>
                    </div>

                    <!-- News & Events Form -->
                    <div id="newsForm" class="dynamic-form">
                        <form action="{{ route('save_news_events') }}" method="POST">
                            @csrf
                            <input type="hidden" name="entryType" value="news">
                            <div class="form-group">
                                <label for="entryDate">Date:</label>
                                <div class="input-with-icon">
                                    <!-- <img src="{{ asset('resource/image/setting/calendar (4) 1.png') }}" alt="Calendar" class="calendar-icon" /> -->
                                    <input type="date" id="date" name="date" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">Title :</label>
                                <input type="text" id="title" maxlength="60" name="title" placeholder="News or event title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea id="description" maxlength="200" name="description" placeholder="Detailed information about the news or event"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="event-start-date">Event Start Date:</label>
                                <div class="input-with-icon">
                                    <input type="date" id="event-start-date" name="startdate" placeholder="Select Start Date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="event-end-date">Event End Date:</label>
                                <div class="input-with-icon">
                                    <input type="date" id="event-end-date" name="enddate" placeholder="Select End Date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location">Location :</label>
                                <input type="text" id="location" maxlength="200" name="location" placeholder="Optional, e.g., 'City Hall'">
                            </div>
                            <button type="submit" class="submit-btn" id="submitNews" disabled>Submit</button>
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
    <div class="accordion-item">
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
                            <th>S.No</th>
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
                                    <a type="button" href="{{ route('user.editdashboard',['id' => $user->id]) }}">
                                        <img src="{{ asset('user_end/images/edit 1.png') }}" alt="Edit" style="width: 20px; height: 20px;"/>
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
            <div class="accordion-item">
                <!-- Accordion Header with a toggle dropdown -->
                <div class="accordion-header" onclick="#">
                    Employee Salary
                </div>
        
                <!-- Dropdown content (initially hidden) -->
                <div id="employeeDetailsDropdown" class="dropdown-content" style="display: block;">
                    <!-- Collapsible Content (Table) -->
                    <div class="content">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Employee ID</th>
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
                    <label>Set Working Hours for All Working Days:</label><br>
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="working_start_time"><br>
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="working_end_time"><br>
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

@extends('user_view.header')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('/user_end/css/setting.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Style for the collapsible button */
        /* .collapsible {
            background-color: white;
            color: black;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: rgba(0,0,0,0.1);
        } */

        /* Style for the collapsible content (table container) */
        .content {
            padding: 0 18px;
            display: block;
            overflow-y: auto;
            background-color: #ffffff;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            background-color: beige;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }


 
    </style>
</head>
    <!-- Main Content -->
    <main class="settings-container">
        <?php 
            
            $permission_array = session('permission_array');

            // dd($permission_array);
            
            ?>
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
            <form id="calendarMasterForm" method="POST" action="holidaybackend.php">
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
                        <input type="text" id="holiday_name" name="holiday_name">
                        <span class="error" id="holidayNameError"></span><br><br>
                    </div>

                    <div class="form-group">
                        <label for="holiday_desc">Holiday Description:</label>
                        <textarea id="holiday_desc" name="holiday_desc"></textarea>
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
                                <label for="thoughtDescription">Description :</label>
                                <textarea id="thoughtDescription" name="description" placeholder="Detailed thoughts or reflections"></textarea>
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
                                <input type="text" id="title" name="title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea id="description" name="description" placeholder="Detailed information about the news or event"></textarea>
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
                                <input type="text" id="location" name="location" placeholder="Optional, e.g., 'City Hall'">
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
                <table>
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
                                <!-- <td><a type="button" href="{{ route('user.editdashboard',['id' => $user->id]) }}" type="">Edit</a></td> -->
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
                    {{ $users->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
<?php 
}
?>
            

            <!-- PMS-->
            {{-- <div class="accordion-item">
                <div class="accordion-header" onclick="window.location.href='{{ url('pms') }}'">
                    PMS-Performance Management System
                </div>
            </div> --}}
        </div>
    </main>

    <!-- JavaScript for toggling dropdown -->
<script>
    function toggleEmployeeDetailsDropdown() {
        var dropdown = document.getElementById("employeeDetailsDropdown");
        if (dropdown.style.display === "none" || dropdown.style.display === "") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }
</script>
    <!-- calender script  -->
     
<script>
    // Function to toggle the visibility of the Calendar Master dropdown
    function toggleCalendarMasterDropdown() {
        var dropdown = document.getElementById("calendarMasterDropdown");
        // Check the current display style, and toggle between 'none' and 'block'
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block"; // Show the dropdown
        } else {
            dropdown.style.display = "none"; // Hide the dropdown
        }
    }

    // Wait for the DOM to be fully loaded before running the JavaScript
    document.addEventListener("DOMContentLoaded", function () {
        const yearSelect = document.getElementById("year");
        const weekOffHolidaySelect = document.getElementById("weekOffHolidaySelect");
        const weekOffSelection = document.getElementById("weekOffSelection");
        const holidayUpdate = document.getElementById("holidayUpdate");
        const workingHoursContainer = document.getElementById("workingHoursContainer");

        // Initially hide the sections related to Week Off, Holiday, and Working Hours
        weekOffSelection.style.display = "none";
        holidayUpdate.style.display = "none";
        workingHoursContainer.style.display = "none"; // Hide working hours section initially

        // Show the appropriate sections based on the selected type (Week Off or Holiday)
        weekOffHolidaySelect.addEventListener("change", function () {
            const selectedOption = weekOffHolidaySelect.value;

            // If 'Week Off' is selected, show week-off selection and working hours section
            if (selectedOption === "weekoff") {
                weekOffSelection.style.display = "block";
                holidayUpdate.style.display = "none";
                workingHoursContainer.style.display = "block"; // Show working hours input fields
            } 
            // If 'Holiday' is selected, show the holiday details section
            else if (selectedOption === "holiday") {
                weekOffSelection.style.display = "none";
                holidayUpdate.style.display = "block";
                workingHoursContainer.style.display = "none"; // Hide working hours section
            }
        });

        // Function to populate the year dropdown dynamically (current year + next 50 years)
        function populateYearDropdown() {
            const currentYear = new Date().getFullYear(); // Get the current year
            // Populate the dropdown with years from the current year to the next 50 years
            for (let year = currentYear; year <= currentYear + 50; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year; // Display the year in the dropdown
                yearSelect.appendChild(option); // Append the option to the dropdown
            }
        }

        // Call populateYearDropdown when DOM is ready to populate the year dropdown
        populateYearDropdown();

        // Event listener to update the working hours dynamically based on week-off days
        const weekOffCheckboxes = document.querySelectorAll('input[name="weekoff[]"]');
        weekOffCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateWorkingHoursFields(); // Update working hours based on the checked week-off days
            });
        });

        // Function to update working hours based on selected week-off days
        function updateWorkingHoursFields() {
            const weekOffDays = [];
            workingHoursContainer.innerHTML = "";  // Clear any existing working hours fields

            // Loop through the checkboxes and collect the selected (checked) week-off days
            weekOffCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    weekOffDays.push(checkbox.value); // Add the checked day to the weekOffDays array
                }
            });

            const allDays = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
            const workingDays = allDays.filter(day => !weekOffDays.includes(day)); // Filter out week-off days from the working days

            // If there are working days left, show the working hours input fields
            if (workingDays.length > 0) {
                workingHoursContainer.innerHTML = `
                    <label>Set Working Hours for All Working Days:</label><br>
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="working_start_time"><br>
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="working_end_time"><br>
                `;
            } else {
                // If no working days are left (all days selected as week off), show a message
                workingHoursContainer.innerHTML = "<p>No working days left. Please select week off days first.</p>";
            }
        }
    });
</script>
    <script>

      // Get all collapsible buttons
      var coll = document.getElementsByClassName("collapsible");

// Loop through the buttons and add an event listener for the click event
for (var i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        // Toggle the "active" class for the button
        this.classList.toggle("active");

        // Get the next element (the content div)
        var content = this.nextElementSibling;

        // Toggle the display of the content (show or hide it)
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
}

        function toggleDropdown() {
            const dropdownContent = document.getElementById("dropdownContent");
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
        }

        // Enable submit button for Thought of the Day form
        document.getElementById("thoughtDate").addEventListener("input", validateThoughtForm);
        document.getElementById("thoughtDescription").addEventListener("input", validateThoughtForm);

        function validateThoughtForm() {
            const thoughtDate = document.getElementById("thoughtDate").value;
            const thoughtDescription = document.getElementById("thoughtDescription").value;
            const submitButton = document.getElementById("submitThought");

            if (thoughtDate && thoughtDescription) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Enable submit button for News & Events form
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

            if (date && title && description && eventStartDate && eventEndDate && location) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
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

        document.addEventListener('DOMContentLoaded', function () {
            const calendarInput = document.querySelector("#thoughtDate");
            const calendarIcon = document.querySelector(".calendar-icon");

            // Initialize Flatpickr on the input
            const calendar = flatpickr(calendarInput, {
                dateFormat: "d/m/Y", // DD/MM/YYYY format
                allowInput: true
            });

            // Open the calendar when clicking on the image
            calendarIcon.addEventListener("click", () => {
                calendar.open();
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Initialize Flatpickr for single date field
            const singleDatePicker = flatpickr("#date", {
                dateFormat: "d/m/Y", // Format: DD/MM/YYYY
                allowInput: true, // Allows manual input
            });

            // Initialize Flatpickr for the start date field
            const startDatePicker = flatpickr("#event-start-date", {
                dateFormat: "d/m/Y", // Format: DD/MM/YYYY
                allowInput: true, // Allows manual input
            });

            // Initialize Flatpickr for the end date field
            const endDatePicker = flatpickr("#event-end-date", {
                dateFormat: "d/m/Y", // Format: DD/MM/YYYY
                allowInput: true, // Allows manual input
            });

            // Add click event to calendar icons
            document.querySelectorAll(".calendar-icon").forEach((icon) => {
                icon.addEventListener("click", function () {
                    // Open the corresponding date picker
                    const inputField = this.nextElementSibling; // Target the input next to the icon
                    if (inputField.id === "date") {
                        singleDatePicker.open(); // Open single date picker
                    } else if (inputField.id === "event-start-date") {
                        startDatePicker.open(); // Open start date picker
                    } else if (inputField.id === "event-end-date") {
                        endDatePicker.open(); // Open end date picker
                    }
                });
            });
        });
    </script>
@endsection

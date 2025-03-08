@extends('user_view.header')

@section('content')
<link rel="stylesheet" href="{{ asset('/user_end/css/setting.css') }}">
<head>
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
            overflow: hidden;
            background-color: #f1f1f1;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
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
            if(in_array(11,$permission_array)){?>
            
            <div class="accordion-item">
                <div class="accordion-header" onclick="window.location.href='{{ url('holiday') }}'">
                    Calender Master
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
            if(in_array(12,$permission_array)){?>
            
            <div class="accordion-item">
                <div class="accordion-header">
                    Employee Details Edit
                </div>
            </div>

            {{-- <button class="collapsible">Open Table</button> --}}

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
                    <td><button type="">Edit</button></td>
                </tr>
                    
                @endforeach
                
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links() }} <!-- Pagination links -->
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

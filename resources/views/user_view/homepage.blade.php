@extends('user_view.header');
@section('content')
<?php
// dd($logs);
error_reporting(0);
// $permission_array = session('permission_array');
// dd($permission_array);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href=
    "{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    <!-- Add Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

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

    <!-- First main for three sections -->
    <main class="main-group">
        <section class="greeting">
 
            @foreach ($logs as $log)
            <h2>Good Morning</h2>
            <div class="top-cards">
                <!-- Check In Card -->
                <div class="card checkin">
                    <img src="{{ asset('user_end/images/Group490.png'); }}" alt="">
                    <h4>Check In</h4>
                    <p>{{ \Carbon\Carbon::parse($log->login_time)->format('H:i:s') }}</p>
                   
                </div>

                <!-- Check Out Card -->
                <div class="card checkout">
                    <img src="{{ asset('user_end/images/Group491.png'); }}" alt="">
                    <h4>Check Out</h4>
                    <p>{{ $log->logout_time ? \Carbon\Carbon::parse($log->logout_time)->format('H:i:s') : '' }}</p>
                </div>
                @endforeach

                <!-- Birthday Card -->
                <!-- Birthday Carousel Container -->
                <!-- Birthday Card -->
        <!-- Birthday Carousel Container -->
        <div class="birthday-carousel-container">
            <div class="birthday-carousel" id="birthdayCarousel">
                @foreach ($upcomingBirthdays->filter(function($birthday) {
                    return \Carbon\Carbon::parse($birthday->birthdate)->isToday();
                }) as $birthday)
                <div class="card birthday">
                    <img src="{{ asset('user_end/images/Group303.png') }}" height="40" width="40" alt="Avatar">
                    <h6>Wish To {{ $birthday->Employee_Name }}</h6>
                    <p>Happy Birthday <span class="count-circle">{{ $birthday->age }}</span></p>
                </div>
                @endforeach
            </div>
            <!-- Navigation buttons -->
            <!-- <button class="prev" id="prevSlide">❮</button> 
            <button class="next" id="nextSlide">❯</button> -->
        </div>

            </div>

            <div class="bottom-cards">
                <!-- Thought of the Day Card -->
                <div class="card thought">
                    <img src="{{ asset('user_end/images/Group326.png'); }}" alt="">
                    <h4>Thought Of The Day</h4>
                    <p>{{ $thoughtOfTheDay->thought }}</p>
                </div>

                <!-- Upcoming Holiday Card -->
                <div class="card holiday1">
                    <h4>Upcoming Holidays</h4>

                   
                </div>
            </div>

        </section>
       
        <!-- Floating Check-Out Button -->
        <!-- <form action="{{route('user.logout')}}" method="POST"><div id="floating-btn">
            @csrf
            <button type="submit" class="fas fa-power-off" style="color: #ffffff; font-size: 30px;"></button> -->
            <!-- Power off icon with custom color -->
        <!-- </div></form> -->
        <!-- <div id="floating-btn">Check Out</div> -->

        <script>
            const btn = document.getElementById('floating-btn');
            let isDragging = false;
            let mouseDown = false;

            btn.addEventListener('mousedown', function (e) {
                mouseDown = true; // Set the mouseDown state to true
                const offsetX = e.clientX - btn.offsetLeft;
                const offsetY = e.clientY - btn.offsetTop;

                function mouseMoveHandler(e) {
                    if (mouseDown) {
                        isDragging = true; // Set dragging true when movement is detected
                        btn.style.left = `${e.clientX - offsetX}px`;
                        btn.style.top = `${e.clientY - offsetY}px`;
                    }
                }

                // function mouseUpHandler() {
                //     if (!isDragging && mouseDown) {
                //         // If no drag occurred, execute check-out logic
                //         alert("Check-Out Process Initiated");
                //         window.location.href = 'logout.php';
                //     }

                //     mouseDown = false; // Reset the mouseDown state
                //     isDragging = false;
                //     document.removeEventListener('mousemove', mouseMoveHandler);
                //     document.removeEventListener('mouseup', mouseUpHandler);
                // }

                // document.addEventListener('mousemove', mouseMoveHandler);
                // document.addEventListener('mouseup', mouseUpHandler);
            });
        </script>
      
        <section class="to-do-list">
            <h3>To-do List</h3>
            <form id="todo-form" class="to-do-list-container" method="POST" action="{{ route('user.save_todo') }}">
                @csrf
                <div class="to-do-list-container">
                    <div class="date-picker-container">
                        <input type="date" name="task_date" id="task_date" class="input-field" required>
                    </div>

                    <div class="form-group">
                        <label for="project">Project</label>
                        <input type="text" id="project" name="project_name" placeholder="Project Name"
                            class="input-field" required>
                    </div>

                    <div class="form-group">
                        <label for="task">Task</label>
                        <input type="text" id="task" name="task_name" placeholder="Task Name" class="input-field"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="hours">Hours</label>
                        <input type="time" id="hours" name="hours" class="input-field" value="00:00:00"
                            placeholder="HH:MM:SS" required>
                    </div>

                    <button type="submit" class="save-button">Save</button>
                </div>
            </form>
        </section>

        <!-- Success Modal -->
        <div id="success-modal" style="display: none;">
            <div class="modal-content">
                <p>Task saved successfully!</p>
                <button onclick="closeSuccessModal()">Close</button>
            </div>
        </div>




        <!-- CSS for Popup -->
        <style>
            /* Modal Background */
            #success-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                /* Semi-transparent background */
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            /* Modal Content */
            #success-modal .modal-content {
                background: white;
                padding: 20px;
                border-radius: 8px;
                max-width: 400px;
                width: 100%;
                text-align: center;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Close Button */
            #success-modal .modal-content button {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 10px;
            }

            #success-modal .modal-content button:hover {
                background-color: #45a049;
            }

            /* Blur Effect for Background */
            body.modal-active {
                /* filter: blur(5px);*/
            }

            /* Optionally, add some transitions for smoother effects */
            #success-modal {
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            body.modal-active {
                transition: filter 0.3s ease;
            }
        </style>



<section class="upcoming-anniversary">
    <h3>Anniversary</h3>
    <div class="anniversary">
        @forelse ($anniversaries as $anniversary)
        <div class="employee-card">
            <div class="employee-info">
                <h3><strong>{{ $anniversary->Employee_Name }}</strong></h3>
                <div class="details">
                    <p>{{ $anniversary->yearsCompleted }} Years Completed</p>
                    <div class="badge">{{ $anniversary->badgeText }}</div>
                </div>
            </div>
        </div>
        @empty
        <p>No anniversaries for the current month.</p>
        @endforelse
    </div>
</section>


       
<section class="calendar-container">
    <h3 class="calendar-header">Calendar</h3>
    <div class="main-cal">
        <div id="calendar-controls">
            <button id="prev-month" class="slider-btn">&lt;</button>

            <div id="dropdown-container">
                <select id="year-select" class="slider-btn"></select>
                <select id="month-select" class="slider-btn"></select>
            </div>

            <button id="next-month" class="slider-btn">&gt;</button>
        </div>

        <div id="calendar"></div>
    </div>
</section>


    </main>

    <!-- Second main for four sections -->
    <!-- <main class="main-group">
        <section class="approval-pending">
            <h3>Approval Pending</h3>
            <div class="approval-cards">
                <!-- Leave Card 
                <div class="approval-card">
                    <div class="card-left">
                        <img src="Leave.png" alt="Leave Icon" class="icon">
                        <div class="details">
                            <h4>Leave</h4>
                            <p>Privilege Leave</p>
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="cake 5.png" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>

                <!-- Task Card 
                <div class="approval-card">
                    <div class="card-left">
                        <img src="Task.png" alt="Task Icon" class="icon">
                        <div class="details">
                            <h4>Task</h4>
                            <p>UI/UX Designer</p>
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="cake 5.png" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>

                <!-- Meeting Card 
                <div class="approval-card">
                    <div class="card-left">
                        <img src="Meeting (1).png" alt="Meeting Icon" class="icon">
                        <div class="details">
                            <h4>Meeting</h4>
                            <p>Frontend Developer</p>
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="cake 5.png" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>
            </div>
        </section> -->
    <main class="main-group">
        <section class="approval-pending">
            <h3>Approval Pending</h3>
            <div class="approval-cards">
                <!-- Leave Card -->
                <div class="approval-card" onclick="openModal()">
                    <div class="card-left">
                        <img src="{{ asset('user_end/images/Leave.png'); }}" alt="Leave Icon" class="icon">
                        <div class="details">
                            <h4>Leave</h4>
                           
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>

                <!-- Task Card -->
                <div class="approval-card" onclick="openTaskModal()">
    <div class="card-left">
        <img src="{{ asset('user_end/images/Task.png'); }}" alt="Task Icon" class="icon">
        <div class="details">
            <h4>Task</h4>
        </div>
    </div>
    <div class="card-right">
        <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
    </div>
</div>


                <!-- Meeting Card -->
                <!-- <div class="approval-card">
                    <div class="card-left">
                        <img src="../resource/image/dashboard/Meeting (1).png" alt="Meeting Icon" class="icon">
                        <div class="details">
                            <h4>Meeting</h4>
                            
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="../resource/image/dashboard/cake 5.png" alt="Alert Icon" class="alert-icon">
                    </div>
                </div> -->
            </div>
        </section>

       

        <!-- Popup Modal -->
        <div id="leaveModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Leave Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee No.</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTaskModal()">&times;</span>
        <h2>Task</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Hours</th>
                    <th>Action</th> <!-- New Column for Delete Icon -->
                </tr>
            </thead>
            <tbody>
                @foreach($toDoList as $task)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($task->date)->format('d-m-Y') }}</td>
                        <td>{{ $task->project_name }}</td>
                        <td>{{ $task->task }}</td>
                        <td>{{ $task->hours }}</td>
                        <td>
                            <!-- Add Delete Button -->
                            <button onclick="deleteTask({{ $task->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    // Open the task modal
function openTaskModal() {
    document.getElementById('taskModal').style.display = 'block';  // Show the modal
}

// Close the task modal
function closeTaskModal() {
    document.getElementById('taskModal').style.display = 'none';  // Hide the modal
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('taskModal');
    if (event.target === modal) {
        closeTaskModal();
    }
}

</script>

        <!-- <section class="news-events"> 
            <h3>News & Events</h3>
            <div class="container-events">
                <ul>
                    <li>
                        <span class="date">18 NOV</span>
                        <span class="event"><strong>Board Meeting</strong>
                            <p><small>Meet all project managers</small></p>
                        </span>

                    </li>
                    <li>
                        <span class="date">18 NOV</span>
                        <span class="event"><strong>Updated Company Policy</strong>
                            <p><small>Meet all project managers</small></p>
                        </span>
                    </li>
                    <li>
                        <span class="date">18 NOV</span>
                        <span class="event"><strong>Board Meeting</strong>
                            <p><small>Meet all project managers</small></p>
                        </span>
                    </li>
                    <li>
                        <span class="date">18 NOV</span>
                        <span class="event"><strong>Board Meeting</strong>
                            <p><small>Meet all project managers</small> </p>
                        </span>
                    </li>
                </ul>
            </div>
        </section>-->
        <section class="news-events">
    <h3>News & Events</h3>
    <div class="container-events">
        <ul>
            @foreach ($newsAndEvents as $event)
            <li>
                <span class="date">{{ \Carbon\Carbon::parse($event->startdate)->format('d M') }}</span>
                <span class="event"><strong>{{ $event->title }}</strong>
                    <p><small>{{ $event->description }}</small></p>
                </span>
            </li>
            @endforeach
        </ul>
    </div>
</section>





      
        <!-- <section class="leaves">
            <h3>Leaves</h3>
            <ul>
              
            </ul>
        </section> -->
        <section class="leaves">
    <h3>Leave Types</h3>
    <ul>
        @foreach($leaveUsage as $leave)
            <li>
                <strong>{{ $leave['leaveType'] }}</strong>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ $leave['percentage'] }}%; background-color: {{ $leave['progressColor'] }};"></div>
                </div>
                <p>{{ $leave['takenLeave'] }} / {{ $leave['maxLeave'] }} days taken ({{ round($leave['percentage'], 2) }}% used)</p>
                <!-- <p><strong>Remaining Leaves:</strong> {{ $leave['remainingLeave'] }} days</p> -->

                <!-- If applicable, show no carry forward and no leave encashment details -->
                <!-- @if($leave['noCarryForward'])
                    <p><strong>No Carry Forward:</strong> Yes</p>
                @else
                    <p><strong>No Carry Forward:</strong> No</p>
                @endif -->

                <!-- @if($leave['noLeaveEncash'])
                    <p><strong>No Leave Encashment:</strong> Yes</p>
                @else
                    <p><strong>No Leave Encashment:</strong> No</p>
                @endif -->
            </li>
        @endforeach
    </ul>
</section>


<style>
    .progress-bar-container {
        width: 100%;
        height: 20px;
        background-color: #f3f3f3;
        border-radius: 10px;
        margin-top: 5px;
    }

    .progress-bar {
        height: 100%;
        border-radius: 10px;
    }
</style>



       
        <section class="upcoming-birthdays">
        <h3>Upcoming Birthdays</h3>
<div class="birthday-cards">
        @forelse ($upcomingBirthdays as $birthday)
        <div class="employee-card">
            <img src="{{ asset('user_end/images/default_avatar.png') }}" alt="Profile Image" class="profile-image">
            <div class="employee-info">
                <h3><strong>{{ $birthday->Employee_Name }}</strong></h3>
                <p>{{ $birthday->Designation }}</p>
                <div class="badge">{{ $birthday->badgeText }}</div>
            </div>
            </div>
        
        @empty
        <p>No upcoming birthdays this month.</p>
        @endforelse
    </div>
</section>







    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Performance',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: '#6c63ff',
                    backgroundColor: 'rgba(108, 99, 255, 0.2)',
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Initialize global variables
    const calendarContainer = document.getElementById("calendar");
    const yearSelect = document.getElementById("year-select");
    const monthSelect = document.getElementById("month-select");
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    // Function to populate year and month select dropdowns
    function populateDropdowns() {
        // Populate Year Dropdown
        yearSelect.innerHTML = '';
        for (let i = currentYear - 50; i <= currentYear + 50; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            if (i === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }

        // Populate Month Dropdown
        monthSelect.innerHTML = '';
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        months.forEach((month, index) => {
            const option = document.createElement("option");
            option.value = index;
            option.textContent = month;
            if (index === currentMonth) option.selected = true;
            monthSelect.appendChild(option);
        });
    }

    // Function to generate calendar
    function generateCalendar(year, month) {
        // Get the first day of the month and the number of days in the month
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const numDays = lastDay.getDate();
        const firstDayOfWeek = firstDay.getDay(); // 0 - Sunday, 1 - Monday, etc.

        // Clear previous calendar
        calendarContainer.innerHTML = '';

        // Add day headers (Sun, Mon, Tue, etc.)
        const headers = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        headers.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.classList.add('day', 'header');
            dayHeader.textContent = day;
            calendarContainer.appendChild(dayHeader);
        });

        // Add empty days before the start of the month
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('day', 'empty');
            calendarContainer.appendChild(emptyDay);
        }

        // Add actual days
        for (let day = 1; day <= numDays; day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day');
            dayElement.textContent = day;
            calendarContainer.appendChild(dayElement);
        }
    }

    // Event listeners for month/year dropdown changes
    yearSelect.addEventListener("change", (e) => {
        currentYear = parseInt(e.target.value);
        generateCalendar(currentYear, currentMonth);
    });

    monthSelect.addEventListener("change", (e) => {
        currentMonth = parseInt(e.target.value);
        generateCalendar(currentYear, currentMonth);
    });

    // Event listeners for previous and next buttons
    document.getElementById("prev-month").addEventListener("click", () => {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        yearSelect.value = currentYear;
        monthSelect.value = currentMonth;
        generateCalendar(currentYear, currentMonth);
    });

    document.getElementById("next-month").addEventListener("click", () => {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        yearSelect.value = currentYear;
        monthSelect.value = currentMonth;
        generateCalendar(currentYear, currentMonth);
    });

    // Initialize the calendar
    populateDropdowns();
    generateCalendar(currentYear, currentMonth);
</script>



    <script>
        function toggleOtherInput(selectElement) {
            const otherInput = document.getElementById('otherNote');

            if (selectElement.value === 'Other') {
                // Show the input field for manual note entry
                otherInput.style.display = 'block';
                otherInput.focus(); // Automatically focus the input field
            } else {
                // Hide the input field and clear its value
                otherInput.style.display = 'none';
                otherInput.value = '';
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get all navigation links
            var navLinks = document.querySelectorAll('nav ul li a');

            // Initially remove the active class from all links
            navLinks.forEach(function (link) {
                link.classList.remove('active');
            });

            // Get the current page's filename
            var currentPage = window.location.pathname.split('/').pop();

            // Loop through each link and check if its href matches the current page
            navLinks.forEach(function (link) {
                var linkPath = link.getAttribute('href').split('/').pop();

                // If the current page matches the link's href, add the 'active' class
                if (linkPath === currentPage) {
                    link.classList.add('active');
                }
            });

            // If no page matches (like the user is on the default page), add the active class to Dashboard
            if (currentPage === '' || currentPage === 'ESS_HOME.php' || currentPage === 'ESS_HOME.PHP') {
                // Ensure Dashboard is highlighted on the first login
                navLinks[0].classList.add('active');
            }
        });
    </script>

@endsection
</body>
</html>
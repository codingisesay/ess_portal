@extends('user_view.header')
@section('content')
<?php
// dd($logs);
error_reporting(0);
// $permission_array = session('permission_array');
// dd($permission_array);
// dd($todayBirthdays);
// dd($leaveLists);
// dd($leaveUsage);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

    {{-- @if(session('success'))
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
                    <p>{{ date('h:i:s A', strtotime($log->login_time)) }}</p>
                   
                </div>

                <!-- Check Out Card -->
                <div class="card checkout">
                    <img src="{{ asset('user_end/images/Group491.png'); }}" alt="">
                    <h4>Check Out</h4>
                    <p>{{ date('h:i:s A', strtotime($log->logout_time)) }}</p>
                </div>
                @endforeach

                
                <!-- Birthday Card -->
                <div class="birthday-carousel-container">
    <div class="birthday-carousel" id="birthdayCarousel">
        @php
            $todaysBirthdays = $todayBirthdays->filter(function($birthday) {
                return \Carbon\Carbon::parse($birthday->birthdate)->isToday();
            });
        @endphp

        @if ($todaysBirthdays->isEmpty())  <!-- Check if no birthdays today -->
            <div class="birthday card">
                <img src="{{ asset('user_end/images/Group303.png') }}" height="40" width="40" alt="Avatar">
                <h6>No birthdays today</h6>
                <p>Check back later!</p>
            </div>
        @else  <!-- If there are birthdays, loop through them -->
            @foreach ($todaysBirthdays as $birthday)
                <div class="birthday card">
                    <img src="{{ asset('user_end/images/Group303.png') }}" height="40" width="40" alt="Avatar">
                    <h6>Wish To {{ $birthday->employee_nme }}</h6>
                    <p>Happy Birthday</p>
                </div>
            @endforeach
        @endif
    </div>
    <!-- <span class="count-circle">{{ $birthday->age }}</span> -->
    <!-- Navigation buttons -->
    <!-- <button class="prev" id="prevSlide">❮</button>
    <button class="next" id="nextSlide">❯</button> -->
</div>


            </div>
            <!-- Include the auto-scrolling JavaScript -->
<script>
    window.onload = function() {
        const carousel = document.getElementById("birthdayCarousel");
        let scrollAmount = 0;
        const scrollStep = 1;  // How much to scroll per interval (adjust for speed)
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;  // Maximum scroll width

        function autoScroll() {
            if (scrollAmount >= maxScroll) {
                scrollAmount = 0;  // Reset to the beginning once we reach the end
            } else {
                scrollAmount += scrollStep;  // Scroll by the defined step
            }
            carousel.scrollLeft = scrollAmount;  // Apply the scroll amount to the carousel
        }

        // Start the auto-scroll function every 40ms (this can be adjusted)
        setInterval(autoScroll, 60); 
    }
</script>

            <div class="bottom-cards">
                <!-- Thought of the Day Card -->
                <div class="card thought">
                    <img src="{{ asset('user_end/images/Group326.png'); }}" alt="">
                    <h4>Thought Of The Day</h4>
                    @if($thoughtOfTheDay)
                    <p>{{ $thoughtOfTheDay->thought }}</p>
                @else
                    <p>No thought for today.</p>
                @endif
                    
                </div>

                <!-- Upcoming Holiday Card -->
                <div class="card holiday1">
                    <h4>Upcoming Holidays</h4>
                    
                    @if($upcomingHolidays->isNotEmpty())
                        <ul>
                            @foreach($upcomingHolidays as $holiday)
                                <li>
                                    <strong>{{ $holiday->formatted_date }}</strong> - {{ $holiday->holiday_name }} ({{ $holiday->day }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No upcoming holidays this year.</p>
                    @endif
                </div>
            </div>
        </section>
     

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
                        <input type="text" id="project" maxlength="200" name="project_name" placeholder="Project Name"
                            class="input-field" required>
                    </div>

                    <div class="form-group">
                        <label for="task">Task</label>
                        <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Name" class="input-field"
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

<section class="upcoming-anniversary">
    <h3>Work Anniversary</h3>
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

  
    <main class="main-group">
        <section class="approval-pending">
            <h3>Approval Pending</h3>
            <div class="approval-cards">
                <!-- Leave Card -->
                <div class="approval-card " id="leave-card" onclick="openLeaveModal()">
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
                <div class="approval-card {{ $toDoList->isNotEmpty() ? 'glow-effect' : '' }}" id="task-card"  onclick="openTaskModal()" >
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
            </div>
        </section>
        <style>
.glow-effect {
    position: relative;
    animation: alertGlow 1.5s ease-in-out infinite;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

/* Flashing alert animation */
@keyframes alertGlow {
    0% {
        box-shadow: 0 0 10px rgba(255, 69, 0, 0.5); /* Soft red/orange glow */
        transform: scale(1);
    }
    50% {
        box-shadow: 0 0 25px rgba(255, 69, 0, 0.8); /* Stronger red/orange glow */
        transform: scale(1.05);
    }
    100% {
        box-shadow: 0 0 10px rgba(255, 69, 0, 0.5); /* Soft red/orange glow */
        transform: scale(1);
    }
}

/* Optional: Subtle alert glow without animation */
.glow-effect.alert-static {
    box-shadow: 0 0 15px rgba(255, 69, 0, 0.5);
}

/* Hover effect to emphasize urgency */
.glow-effect:hover {
    box-shadow: 0 0 30px rgba(255, 69, 0, 1); /* More intense glow */
    transform: scale(1.05);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

        </style>


        <!-- Popup Modal -->
        <div id="leaveModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeLeaveModal()">&times;</span>
        <h2>Leave Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee No.</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Days Count</th>
                    <th>Reason</th>
                    <th>Approve</th>
                    <th>Reject</th>
                </tr>
            </thead>
            <tbody>
            
                @foreach ($leaveLists as $leaveApply)
                @foreach ($leaveApply as $leave)
                    <tr>
                        <td>{{ $leave->employee_no }}</td>
                        <td>{{ $leave->employee_name }}</td>
                        <td>{{ $leave->leave_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->leave_start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->leave_end_date)->format('d-m-Y') }}</td>
                        <td>{{ $leave->days_count }}</td>
                        <td>{{ $leave->leave_resion }}</td>
            
                     
                        <td>
                        <form action="{{ route('leave_update_status', ['id' => $leave->leave_appliy_id, 'status' => 'Approved']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="font-size: 24px;  border: none; background: none; cursor: pointer;">
                                ✅
                            </button>
                        </form>
                        </td>
                        <td>
                        <form action="{{ route('leave_update_status', ['id' => $leave->leave_appliy_id, 'status' => 'Reject']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="font-size: 24px; border: none; background: none; cursor: pointer;">
                                ❌
                            </button>
                        </form>
                    </td>

                    </tr>
                @endforeach
            @endforeach
         
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
                    <th>Status</th> <!-- New Column for Delete Icon -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if ($toDoList->isNotEmpty())
                @foreach($toDoList as $task)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($task->date)) }}</td>
                        <td>{{ $task->project_name }}</td>
                        <td>{{ $task->task }}</td>
                        <td>{{ $task->hours }}</td>
                        <td>
                            <form action="{{ route('update_do_do', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $task->id }}">
                                <select name="status">
                                    <option value="{{ $task->status }}" selected>{{ $task->status }}</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit">Update</button>
                            
                        </td>
                    </form>
                    </tr>
                @endforeach
                @endif

                </form>
            </tbody>
        </table>
    </div>
</div>
<script>
    // Open the leave modal
    function openLeaveModal() {
        document.getElementById('leaveModal').style.display = 'block';  // Show the modal
    }

    // Close the leave modal
    function closeLeaveModal() {
        document.getElementById('leaveModal').style.display = 'none';  // Hide the modal
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        var taskModal = document.getElementById('taskModal');
        var leaveModal = document.getElementById('leaveModal');

        // Close task modal if clicked outside
        if (event.target === taskModal) {
            closeTaskModal();
        }

        // Close leave modal if clicked outside
        if (event.target === leaveModal) {
            closeLeaveModal();
        }
    }
</script>
<script>
     // Open the leave modal
     function openTaskModal() {
        document.getElementById('taskModal').style.display = 'block';  // Show the modal
    }

    // Close the leave modal
    function closeTaskModal() {
        document.getElementById('taskModal').style.display = 'none';  // Hide the modal
    }
</script>



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


        <section class="leaves">
            <h3>Leave Types</h3>
            <ul>
                @foreach($leaveUsage as $leave)
                    <li>
                        <strong>{{ $leave[0] }}</strong> <!-- The first item is the leave type name -->
                        <div class="progress-bar-containerr">
                            <div class="progress-barr" style="width: {{ $leave[3] }}%; background-color: 
                                @if($leave[3] <= 50) #4caf50
                                @elseif($leave[3] <= 75) #ff9800
                                @else #f44336
                                @endif;"></div> <!-- This will set the color based on the percentage -->
                        </div>
                        <p>{{ $leave[1] }} / {{ $leave[2] }} days taken ({{ round($leave[3], 2) }}% used)</p>
                    </li>
                @endforeach
            </ul>
        </section>

        


<style>
    .progress-bar-containerr {
        width: 100%;
        height: 20px;
        background-color: #f3f3f3;
        border-radius: 10px;
        margin-top: 5px;
    }

    .progress-barr {
        height: 100%;
        border-radius: 10px;
    }
</style>



       
        <section class="upcoming-birthdays">
        <h3>Upcoming Birthdays</h3>
<div class="birthday-cards">
        @forelse ($upcomingBirthdays as $birthday)
        <div class="employee-card">
            <!-- <img src="{{ asset('storage/'.$birthday->imagelink) }}" alt="Profile Image" class="profile-image"> -->
             <!-- Check if the image exists or use the default image -->
            <img src="{{ asset('storage/' . ($birthday->imagelink ?: 'user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg')) }}" alt="Profile Image" class="profile-image">

            <div class="employee-info">
                <h3><strong>{{ $birthday->employee_nme }}</strong></h3>
                <p>{{ $birthday->designation_name }}</p>
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
    // PHP data passed to JavaScript
    const holidays = <?php echo json_encode($holidays_upcoming); ?>;
    const weekOffs = <?php echo json_encode($week_offs); ?>;

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

        // Highlight days based on holidays and week-offs
        for (let day = 1; day <= numDays; day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day');
            dayElement.textContent = day;

            // Check if the day is a holiday
            const isHoliday = holidays.some(holiday => {
                const holidayDate = new Date(holiday.date);
                return holidayDate.getDate() === day && holidayDate.getMonth() === month && holidayDate.getFullYear() === year;
            });

            // Check if the day is a week-off
            const isWeekOff = weekOffs.some(weekOff => {
                const weekOffDate = new Date(weekOff.date);
                return weekOffDate.getDate() === day && weekOffDate.getMonth() === month && weekOffDate.getFullYear() === year;
            });

            // Add holiday and week-off styling
            if (isHoliday) {
                dayElement.classList.add('holiday');
            }
            if (isWeekOff) {
                dayElement.classList.add('week-off');
            }

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


<style>
     .day.holiday {
        background-color: #f3e39f;
        color: black;
        border-radius: 50%;
    }

    .day.week-off {
        background-color: #8A3366;
        color: white;
        border-radius: 50%;
    }

</style>


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

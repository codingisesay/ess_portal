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

// dd($reimbursementList);
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

    <!-- {{-- @if(session('success'))
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
            @endif --}} -->

            @if($errors->any())
            <div class="alert custom-alert-warning">
            <ul>
            @foreach($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>

            @endforeach
            </ul>
            </div>
            @endif

    <!-- First main for three sections -->
    <main class="main-group ">
        <section class="greeting">
 
            @foreach ($logs as $log)  
            <h2 id="greeting"></h2>

            <div class="top-cards">
                <!-- Check In Card -->
                <div class="card checkin">
                    <img src="{{ asset('user_end/images/Group490.png'); }}" alt="" /><br>
                    <p class="fs-6 mb-0">Check&nbsp;In</p>
                    <small>{{ date('h:i:s A', strtotime($log->login_time)) }}</small>   
                </div>

                <!-- Check Out Card -->
                <div class="card checkout">
                    <img src="{{ asset('user_end/images/Group491.png'); }}" alt=""><br>
                    <p class="fs-6 mb-0">Check&nbsp;Out</p>
                    <small>{{ $log->logout_time ? date('h:i:s A', strtotime($log->logout_time)) : 'First Login' }}</small>
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

                        <div class="birthday card slides-wrapper">
                        <img src="{{ asset('user_end/images/Group303.png') }}" height="40" width="40" alt="Avatar"> <br>
                        @if ($todaysBirthdays->isEmpty())   
                                
                                <h6>No birthdays today</h6>
                                <small>Check back later!</small>
                         
                        @else  
                            @foreach ($todaysBirthdays as $birthday)
                                <div class="slide">
                                    <h6 class="birthday-heading">Wish You Happy Birthday!!</h6>
                                    <p class="birthday-msg">{{ $birthday->employee_nme }}</p>
                                </div>
                            @endforeach 
                        @endif
                        </div>
                    </div> 
                </div> 
                <!-- <div class="birthday-carousel" id="birthdayCarousel">
                    <div class="birthday card"> 
                        <img src="{{ asset('user_end/images/Group303.png') }}" height="40" width="40" alt="Avatar"><br>

                        @php
                            $todaysBirthdays = $todayBirthdays->filter(function($birthday) {
                                return \Carbon\Carbon::parse($birthday->birthdate)->isToday();
                            });
                        @endphp

                        @if ($todaysBirthdays->isEmpty()) 
                            <h6>No birthdays today</h6>
                            <small>Check back later!</small>
                        @else 
                            @foreach ($todaysBirthdays as $birthday)
                       
                                    <h6>Wish To {{ $birthday->employee_nme }}</h6>
                                    <p>Happy Birthday</p>
                      
                            @endforeach
                        @endif
                    </div>
                </div> -->
 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = document.querySelectorAll(".slide");
        const emojis = ["🎉", "🎂", "🎁", "🥳", "🎈", "🍰", "🧁", "🍾", "🎊", "🪅"];
        let currentIndex = 0;

        function getRandomEmoji() {
            return emojis[Math.floor(Math.random() * emojis.length)];
        }

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove("active");
                if (i === index) {
                    slide.classList.add("active");

                    const name = slide.querySelector(".birthday-msg");

                    // Store the original name once
                    if (!name.dataset.original) {
                        name.dataset.original = name.textContent;
                    }

                    // Set content with one emoji before the name
                    name.innerHTML = `${getRandomEmoji()} ${name.dataset.original}`;
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        if (slides.length > 0) {
            showSlide(currentIndex);
            setInterval(nextSlide, 3000); // every 3 seconds
        }
    });
</script>

            </div>
            <!-- Include the auto-scrolling JavaScript -->
  
            <div class="bottom-cards">
                <!-- Thought of the Day Card -->
                <div class="card thought">
                    <img src="{{ asset('user_end/images/Group326.png'); }}" alt=""> <br>
                    <p class="fs-6 mb-0">Thought Of The Day</p>
                    @if($thoughtOfTheDay)
                    <i>{{ $thoughtOfTheDay->thought }}</i>
                @else
                    <small class="text-secondary">No thought for today.</small>
                @endif
                    
                </div>

                <!-- Upcoming Holiday Card -->
                <div class="card holiday1">
                <img src="{{ asset('user_end/images/holiday.png'); }}" alt=""> <br>
                    <p class="fs-6 mb-0">Upcoming Holiday</p>
                  
                    @if($upcomingHolidays->isNotEmpty())
                    @php
                        $firstHoliday = $upcomingHolidays->first();
                    @endphp 
                        <i>
                            {{ $firstHoliday->formatted_date }} : {{ $firstHoliday->holiday_name }} 
                            <!-- ({{ $firstHoliday->day }}) -->
                        </i>
                    @else
                        <i>No upcoming holidays this year.</i>
                    @endif

                    <!-- @if($upcomingHolidays->isNotEmpty())
                        <ul>
                            @foreach($upcomingHolidays as $holiday)
                                <li>
                                    <strong>{{ $holiday->formatted_date }}</strong> - {{ $holiday->holiday_name }} ({{ $holiday->day }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No upcoming holidays this year.</p>
                    @endif -->
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
           
            <h5 class="mt-3">To-do List</h5>
            <form id="todo-form" class="to-do-list-container" method="POST" action="{{ route('user.save_todo') }}">
                @csrf 
                    <!-- Project Field -->
                    <div class="form-group">
                        <div class="floating-label-wrapper">
                            <input type="text" id="project" maxlength="200" name="project_name" Placeholder="Project Name" class="input-field" required>
                            <label for="project">Project</label>
                        </div>
                    </div>

                    <!-- Task Field -->
                    <div class="form-group">
                        <div class="floating-label-wrapper">
                            <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Description" class="input-field" required>
                            <label for="task">Task</label>
                        </div>
                    </div>

                    <!-- Date Field -->
                    <div class="form-group">
                        <div class="floating-label-wrapper">
                            <input type="date" name="task_date" id="task_date" placeholder=" " class="input-field" required>
                            <label for="task_date">Date</label>
                        </div>
                    </div>

                    <!-- Hours Field -->
                    <div class="form-group">
                        <div class="floating-label-wrapper">
                            <input type="time" id="hours" name="hours" class="input-field" value="00:00:00" placeholder=" " required>
                            <label for="hours">Hours</label>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <button type="submit" class="save-button">Save</button>
             

            </form>
        </section>

        <section class="upcoming-anniversary">
            <h5 class="mt-3">Work Anniversary</h5>
            <div class="anniversary">
                @forelse ($anniversaries as $anniversary)
                <div class=" border rounded-3 shadow-sm mb-1">
                    <div class="d-flex justify-content-between p-2">
                        <div class="details"> 
                            <h6 class="mb-0" >{{ $anniversary->Employee_Name }}</h6>
                            <small >{{ $anniversary->yearsCompleted }} Years Completed</small>
                            <div class="badge">{{ $anniversary->badgeText }}</div>
                        </div> 
                        <img class="mb-3" src='https://i.pinimg.com/736x/99/4b/51/994b51b05a506a082ea193492a449ca9.jpg' alt="photo" />
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3">No Carnivals for the current month.</p>
                @endforelse
            </div>
        </section>


       
        <section class="calendar-container">
            <h5 class="calendar-header mt-3">Calendar</h5>
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
            <h5>Approval Pending</h5>
            <div class="approval-cards">
                <!-- Leave Card #FBDC7F-->
                <div class="approval-card {{ (!empty($leaveLists) && collect($leaveLists)->flatten()->isNotEmpty()) ? 'glow-effect' : '' }}" id="leave-card" onclick="openLeaveModal()">
                    <div class="card-left">
                        <div class="leave-approval-icon1"> <x-icon name="leavenoity" /> </div>
                        <div class="details">
                            <h6 class="mb-0" >Leave</h6>
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>

                <!-- Task Card -->
                <div class="approval-card {{ $toDoList->isNotEmpty() ? 'glow-effect' : '' }}" id="task-card"  onclick="openTaskModal()" >
                <div class="card-left">
                <div class="leave-approval-icon2"> <x-icon name="tasknotify" /> </div>
                    <div class="details">
                        <h6>Task</h6>
                    </div>
                </div>
                <div class="card-right">
                    <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
                </div>
            </div>
            <div class="approval-card" id="reimbursement-card" onclick="openReimbursementModal()">
                <div class="card-left">
                <div class="leave-approval-icon3">     <x-icon name="reimpay" /></div>
                    <div class="details">
                        <h6>Reimbursement</h6>
                    </div>
                </div>
                <div class="card-right">
                    <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
                </div>
            </div>  
            <div class="approval-card" id="reimbursement-card" onclick="openAccountModal()">
                <div class="card-left">
                <div class="leave-approval-icon4">   <x-icon name="reimpay" /></div>
                    <div class="details">
                        <h6>Account</h6>
                    </div>
                </div>
                <div class="card-right">
                    <img src="{{ asset('user_end/images/cake 5.png'); }}" alt="Alert Icon" class="alert-icon">
                </div>
            </div>
            </div>
        </section>
             


        <!-- Popup Modal -->
        <div id="leaveModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeLeaveModal()">&times;</span>
        <h5>Leave Details</h5>
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
            @if (!empty($leaveLists))
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
            @endif
            </tbody>
        </table>
    </div>
</div>

<div id="taskModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTaskModal()">&times;</span>
        <h5>Task</h5>
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

<!-- Reimbursement Modal -->
<div id="reimbursementModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReimbursementModal()">&times;</span>
        <h5>Reimbursement Details</h5>
        <table>
            <thead>
                <tr>
                    <th>Reference ID</th>
                    <th>EMP ID</th>
                    <th>Employee Name</th>
                    <th>No. of Bills</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($reimbursementList))
                    @foreach ($reimbursementList as $reimbursement)
                        <tr>
                            <td>{{ $reimbursement->token_number }}</td>
                            <td>{{ $reimbursement->employee_no }}</td>
                            <td>{{ $reimbursement->employee_name }}</td>
                            <td>{{ $reimbursement->no_of_entries }}</td>
                            <td>{{ number_format($reimbursement->total_amount, 2) }}</td> <!-- Display total amount -->
                            <td>{{ $reimbursement->status }}</td> <!-- Display status -->
                            <td>
                                <a href="{{ route('user_claims',['user_id' => $reimbursement->user_id, 'reimbursement_traking_id' => $reimbursement->id]) }}">
                                    <button>View</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No reimbursement details available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div id="accountModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAccountModal()">&times;</span>
        <h5>Account Details</h5>
        <table>
            <thead>
                <tr>
                    <th>Manager ID</th>
                    <th>Manager Name</th>
                    <th>Claim of Employee</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($accountList))
                    @foreach ($accountList as $account)
                        <tr>
                            <td>{{ $account->manager_id }}</td>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->approved_claims }}</td>
                            <td>
                                <button onclick="viewAccountDetails({{ $account->id }})">View</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <!-- <td colspan="4">No account details available.</td> -->
                    </tr>
                     <!-- Dummy Data -->
                     <tr>
                        <td>EMP001</td>
                        <td>Paresh Sir</td>
                        <td>04</td>
                        <td>
                        <a href="{{ route('manager_claims') }}"><button>View</button></a>
                        </td>
                    </tr>
                    <tr>
                    <td>EMP001</td>
                        <td>Akash Sir</td>
                        <td>04</td>
                        <td>
                        <a href="{{ route('manager_claims') }}"><button>View</button></a>
                        </td>
                        
                    </tr>
                @endif
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

<script>
    // Open the reimbursement modal
    function openReimbursementModal() {
        document.getElementById('reimbursementModal').style.display = 'block'; // Show the modal
    }

    // Close the reimbursement modal
    function closeReimbursementModal() {
        document.getElementById('reimbursementModal').style.display = 'none'; // Hide the modal
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        const reimbursementModal = document.getElementById('reimbursementModal');
        if (event.target === reimbursementModal) {
            closeReimbursementModal();
        }
    }
</script>

<script>
    // Open the account modal
    function openAccountModal() {
        document.getElementById('accountModal').style.display = 'block'; // Show the modal
    }

    // Close the account modal
    function closeAccountModal() {
        document.getElementById('accountModal').style.display = 'none'; // Hide the modal
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        const accountModal = document.getElementById('accountModal');
        if (event.target === accountModal) {
            closeAccountModal();
        }
    }

    // Placeholder function for viewing account details
    function viewAccountDetails(accountId) {
        alert('View details for account ID: ' + accountId);
    }
</script>
        <section class="news-events">
            <h5>News & Events</h5>
            <div class="container-events">
                <ul>
                    @foreach ($newsAndEvents as $event)
                    <li>
                        <div class="d-flex">
                        <span class="date my-auto">{{ \Carbon\Carbon::parse($event->startdate)->format('d M') }}</span>
                        <h6>{{ $event->title }}</h6>
                        </div>
                        <small class="text-secondary"> {{ $event->description }} </small>
                   
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>


        <section class="leaves">
            <h5>Leave Types</h5>
            <ul>
                @foreach($leaveUsage as $leave)
                    <li>
                        <h6>{{ $leave[0] }}</h6> <!-- The first item is the leave type name -->
                        <div class="progress-bar-containerr">
                            <div class="progress-barr" style="width: {{ $leave[3] }}%; background-color: 
                                @if($leave[3] <= 50) #4caf50
                                @elseif($leave[3] <= 75) #ff9800
                                @else #f44336
                                @endif;"></div> <!-- This will set the color based on the percentage -->
                        </div>
                       <small> <small class="text-secondary"   >{{ $leave[1] }} / {{ $leave[2] }} days taken ({{ round($leave[3], 2) }}% used)</small></small>
                    </li>
                    <br>
                @endforeach
            </ul>
        </section>

        


       
        <section class="upcoming-birthdays">
        <h5>Upcoming Birthdays</h5>
<div class="birthday-cards">
        @forelse ($upcomingBirthdays as $birthday)
        <div class="employee-card">
            <!-- <img src="{{ asset('storage/'.$birthday->imagelink) }}" alt="Profile Image" class="profile-image"> -->
             <!-- Check if the image exists or use the default image -->
            <img src="{{ asset('storage/' . ($birthday->imagelink ?: 'user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg')) }}" alt="Profile Image" class="profile-image">

            <div class="employee-info">
                <h6 class="mb-0">{{ $birthday->employee_nme }}</h6>
                <p class="text-secondary mb-0">{{ $birthday->designation_name }}</p>
                <div class="bdg" >{{ $birthday->badgeText }}</div>
            </div>
            </div>
        
        @empty
        <p class="text-muted my-3 text-center" >No upcoming birthdays this month.</p>
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
    const today = new Date(); // Get today's date

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

        // Highlight days based on holidays, week-offs, and today's date
        for (let day = 1; day <= numDays; day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day');
            dayElement.textContent = day;

            // Check if the day is today's date
            if (today.getDate() === day && today.getMonth() === month && today.getFullYear() === year) {
                dayElement.classList.add('today');
            }

            // Check if the day is a holiday
            const holiday = holidays.find(holiday => {
                const holidayDate = new Date(holiday.date);
                return holidayDate.getDate() === day && holidayDate.getMonth() === month && holidayDate.getFullYear() === year;
            });

            // Check if the day is a week-off
            const isWeekOff = weekOffs.some(weekOff => {
                const weekOffDate = new Date(weekOff.date);
                return weekOffDate.getDate() === day && weekOffDate.getMonth() === month && weekOffDate.getFullYear() === year;
            });

            // Add holiday and week-off styling
            if (holiday) {
                dayElement.classList.add('holiday');
                dayElement.setAttribute('title', holiday.holiday_name); // Add tooltip for holiday name
            }
            if (isWeekOff) {
                dayElement.classList.add('week-off');
                dayElement.setAttribute('title', 'Week Off'); // Add tooltip for week-off
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

<script>
                function getGreeting() {
                    const now = new Date();
                    const hours = now.getHours();
                    let greeting = "";

                    if (hours >= 5 && hours < 12) {
                        greeting = "Good Morning";
                    } else if (hours >= 12 && hours < 17) {
                        greeting = "Good Afternoon";
                    } else if (hours >= 17 && hours < 21) {
                        greeting = "Good Evening";
                    } else {
                        greeting = "Good Night";
                    }

                    document.getElementById("greeting").textContent = greeting;
                }

                // Call the function when the page loads
                window.onload = getGreeting();
            </script>
@endsection

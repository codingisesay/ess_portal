

@extends('user_view.header');
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href=
    "{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <!-- Add Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    

</head>

<body>
   

    <!-- First main for three sections -->
    <main class="main-group">
        <section class="greeting">
 

            <h2>Good Morning</h2>
            <div class="top-cards">
                <!-- Check In Card -->
                <div class="card checkin">
                    <img src="image/Group490.png" alt="">
                    <h4>Check In</h4>
                   
                </div>

                <!-- Check Out Card -->
                <div class="card checkout">
                    <img src="image/Group491.png" alt="">
                    <h4>Check Out</h4>
                   
                </div>


                <!-- Birthday Card -->
                <!-- Birthday Carousel Container -->
                <div class="birthday-carousel-container">
                    <div class="birthday-carousel" id="birthdayCarousel">
                        <!-- Employee birthday cards will be added dynamically here -->
                    </div>
                    <!-- Navigation buttons -->
                    <!-- <button class="prev" id="prevSlide">❮</button> 
                   <button class="next" id="nextSlide">❯</button> -->
                </div>

            </div>

            <div class="bottom-cards">
                <!-- Thought of the Day Card -->
                <div class="card thought">
                    <img src="image/Group326.png" alt="">
                    <h4>Thought Of The Day</h4>
                    
                </div>

                <!-- Upcoming Holiday Card -->
                <div class="card holiday1">
                    <h4>Upcoming Holidays</h4>

                   
                </div>
            </div>

        </section>
       
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Fetch birthday data from the PHP script
                fetch('fetch_birthday.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Debug: Log fetched data
                        console.log("Fetched birthday data:", data);

                        const birthdayCarousel = document.getElementById('birthdayCarousel');

                        // Check if data is not empty
                        if (data.length > 0) {
                            // Clear previous content
                            birthdayCarousel.innerHTML = "";

                            // Add cards for each employee
                            data.forEach(employee => {
                                console.log("Processing employee:", employee); // Debug each employee

                                const card = document.createElement('div');
                                card.classList.add('card', 'birthday');

                                card.innerHTML = `
                        <img src="../resource/image/dashboard/Group303.png" height="40" width="40" alt="Avatar">
                        <h6>Wish To ${employee.Employee_Name}</h6>
                        <p>Happy Birthday <span class="count-circle">${calculateAge(employee.date_of_birth)}</span></p>
                    `;
                                birthdayCarousel.appendChild(card);
                            });
                        } else {
                            // If no birthdays, still show the card with only the 'Wish To' and 'Happy Birthday' text
                            const card = document.createElement('div');
                            card.classList.add('card', 'birthday');

                            card.innerHTML = `
                    <img src="../resource/image/dashboard/Group303.png" height="40" width="40" alt="Avatar">
                    <h6>Wish To Everyone</h6>
                    <p>Happy Birthday</p>
                `;
                            birthdayCarousel.innerHTML = "";
                            birthdayCarousel.appendChild(card);
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching birthday data:", error);
                        const birthdayCarousel = document.getElementById('birthdayCarousel');
                        birthdayCarousel.innerHTML = "<p>Error loading birthdays.</p>";
                    });
            });

            // Function to calculate the age based on birthdate
            function calculateAge(birthDate) {
                const birthDateObj = new Date(birthDate);
                const today = new Date();
                let age = today.getFullYear() - birthDateObj.getFullYear();
                const month = today.getMonth();
                if (month < birthDateObj.getMonth() || (month === birthDateObj.getMonth() && today.getDate() < birthDateObj.getDate())) {
                    age--;
                }
                return age;
            }

        </script>
       
        <!-- Floating Check-Out Button -->
        <div id="floating-btn">
            <i class="fas fa-power-off" style="color: #ffffff; font-size: 30px;"></i>
            <!-- Power off icon with custom color -->
        </div>
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

                function mouseUpHandler() {
                    if (!isDragging && mouseDown) {
                        // If no drag occurred, execute check-out logic
                        alert("Check-Out Process Initiated");
                        window.location.href = 'logout.php';
                    }

                    mouseDown = false; // Reset the mouseDown state
                    isDragging = false;
                    document.removeEventListener('mousemove', mouseMoveHandler);
                    document.removeEventListener('mouseup', mouseUpHandler);
                }

                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);
            });
        </script>
      
        <section class="to-do-list">
            <h3>To-do List</h3>
            <form id="todo-form" class="to-do-list-container">
                <div class="to-do-list-container">
                    <div class="date-picker-container">
                        <input type="date" name="task_date" id="task_date" class="date-display" required>
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

        <script>
    // Handle form submission via AJAX
    document.getElementById('todo-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Gather form data
        var formData = new FormData(this);

        // Send data to the server via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_todo.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Check the server response
                if (xhr.responseText === 'success') {
                    showSuccessModal(); // Show success modal on success
                    document.getElementById('todo-form').reset(); // Reset the form
                } else {
                    alert('Error saving task: ' + xhr.responseText); // Show error if any
                }
            } else {
                alert('AJAX error: ' + xhr.status); // Show AJAX error
            }
        };
        xhr.send(formData); // Send form data to the server
    });

    // Show success modal and apply blur effect
    function showSuccessModal() {
        document.getElementById('success-modal').style.display = 'flex'; // Show modal
        document.body.classList.add('modal-active'); // Apply blur effect to the body
    }

    // Close the success modal and refresh the page
    function closeSuccessModal() {
        document.getElementById('success-modal').style.display = 'none'; // Hide modal
        document.body.classList.remove('modal-active'); // Remove blur effect from the body
        location.reload(); // Refresh the page
    }
</script>



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
        
    </div>
</section>


       
        <section class="calendar-container">
            <h2 class="calendar-header">Calendar</h2>
            <div class="main-cal">
                <div id="calendar-controls">
                    <button id="prev-month" class="slider-btn">&lt;</button>

                    <!-- Dropdowns for Year and Month placed between the sliders -->
                    <div id="dropdown-container">
                        <select id="year-select" class="slider-btn">
                            <!-- Year options will be populated dynamically in JS -->
                        </select>
                        <select id="month-select" class="slider-btn">
                            <!-- Month options will be populated dynamically in JS -->
                        </select>
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
                        <img src="image/Leave.png" alt="Leave Icon" class="icon">
                        <div class="details">
                            <h4>Leave</h4>
                           
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="image/cake 5.png" alt="Alert Icon" class="alert-icon">
                    </div>
                </div>

                <!-- Task Card -->
                <div class="approval-card" onclick="openTaskModal()">
                    <div class="card-left">
                        <img src="image/Task.png" alt="Task Icon" class="icon">
                        <div class="details">
                            <h4>Task</h4>
                            
                        </div>
                    </div>
                    <div class="card-right">
                        <img src="image/cake 5.png" alt="Alert Icon" class="alert-icon">
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
           
        </table>
    </div>
</div>
<script>
    function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        // Send AJAX request to delete the task
        fetch('delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: taskId }),
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert('Task deleted successfully!');
                location.reload(); // Reload the page to update the task list
            } else {
                alert('Error deleting task: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while deleting the task.');
        });
    }
}

</script>

<style>
    .delete-task {
    background: none;
    border: none;
    color: red;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
}
.delete-task:hover {
    color: darkred;
}

</style>
<script>
    // Open Leave Modal
    function openModal() {
        document.getElementById("leaveModal").style.display = "flex";
    }

    // Close Leave Modal
    function closeModal() {
        document.getElementById("leaveModal").style.display = "none";
    }

    // Fetch and populate leave data
    fetch("fetch_pending_leaves.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.querySelector("#leaveModal tbody");
            tableBody.innerHTML = ""; // Clear existing rows

            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='7'>No leave requests found.</td></tr>";
            } else {
                data.forEach(leave => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${leave.Employee_NO || "N/A"}</td>
                            <td>${leave.Employee_Name || "N/A"}</td>
                            <td>${leave.leave_type || "N/A"}</td>
                            <td>${leave.start_date || "N/A"}</td>
                            <td>${leave.end_date || "N/A"}</td>
                            <td>${leave.reason || "N/A"}</td>
                            <td>
                                <button class="approve-btn" onclick="processLeave(${leave.request_id}, 'APPROVED')">Approve</button>
                                <button class="reject-btn" onclick="processLeave(${leave.request_id}, 'REJECTED')">Reject</button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error("Error fetching data:", error));

    // Function to process leave requests
    function processLeave(requestId, action) {
        fetch("process_manager_approval.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `request_id=${requestId}&status=${action}`

        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Refresh the page after approving/rejecting
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error processing leave request:", error));
    }

    // Close modal when clicking outside of it
    window.onclick = function (event) {
        const leaveModal = document.getElementById("leaveModal");
        if (event.target === leaveModal) {
            closeModal();
        }
    };
</script>

        <script>
            // Open Leave Modal
            function openModal() {
                document.getElementById("leaveModal").style.display = "flex"; // Use flex to show the modal
            }

            // Close Leave Modal
            function closeModal() {
                document.getElementById("leaveModal").style.display = "none"; // Hide the modal
            }

            // Open Task Modal
            function openTaskModal() {
                document.getElementById("taskModal").style.display = "flex"; // Use flex to show the modal
            }

            // Close Task Modal
            function closeTaskModal() {
                document.getElementById("taskModal").style.display = "none"; // Hide the modal
            }

            // Close modal when clicking outside of it
            window.onclick = function (event) {
                const leaveModal = document.getElementById("leaveModal");
                const taskModal = document.getElementById("taskModal");

                if (event.target === leaveModal) {
                    closeModal();
                }
                if (event.target === taskModal) {
                    closeTaskModal();
                }
            };

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
          
        </ul>
    </div>
</section>





      
        <section class="leaves">
            <h3>Leaves</h3>
            <ul>
              
            </ul>
        </section>
       
        <section class="upcoming-birthdays">
    <h3>Upcoming Birthdays</h3>
    <div class="birthday-cards">
       
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
        $(document).ready(function () {
            let currentYear = new Date().getFullYear();
            let currentMonth = new Date().getMonth(); // 0-based month for internal use

            // Initialize the year and month dropdowns
            populateYearDropdown();
            populateMonthDropdown();
            updateMonthDisplay();
            loadCalendar(currentYear, currentMonth + 1); // 1-based month for display

            // Handle year change
            $('#year-select').on('change', function () {
                currentYear = parseInt($(this).val());
                loadCalendar(currentYear, currentMonth + 1);
            });

            // Handle month change
            $('#month-select').on('change', function () {
                currentMonth = parseInt($(this).val()) - 1; // 0-based month
                loadCalendar(currentYear, currentMonth + 1); // 1-based month for display
            });

            // Handle previous and next month clicks
            $("#prev-month").on("click", function () {
                if (currentMonth === 0) {
                    currentMonth = 11;
                    currentYear -= 1;
                } else {
                    currentMonth -= 1;
                }
                updateMonthDisplay();
                loadCalendar(currentYear, currentMonth + 1); // 1-based month
                updateDropdowns(); // Update dropdowns to match the new month/year
            });

            $("#next-month").on("click", function () {
                if (currentMonth === 11) {
                    currentMonth = 0;
                    currentYear += 1;
                } else {
                    currentMonth += 1;
                }
                updateMonthDisplay();
                loadCalendar(currentYear, currentMonth + 1); // 1-based month
                updateDropdowns(); // Update dropdowns to match the new month/year
            });

            // Update the displayed month in the slider
            function updateMonthDisplay() {
                const monthName = new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' });
                $("#current-month").text(`${monthName} ${currentYear}`);
            }

            // Populate the year dropdown
            function populateYearDropdown() {
                const yearSelect = $('#year-select');
                const startYear = currentYear - 5; // Starting from 5 years before current year
                const endYear = currentYear + 5; // Ending at 5 years after current year

                for (let year = startYear; year <= endYear; year++) {
                    yearSelect.append(new Option(year, year, year === currentYear, year === currentYear));
                }
            }

            // Populate the month dropdown
            function populateMonthDropdown() {
                const monthSelect = $('#month-select');
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                months.forEach((month, index) => {
                    monthSelect.append(new Option(month, index + 1, index === currentMonth, index === currentMonth)); // 1-based index
                });
            }

            // Fetch calendar data and render calendar
            function loadCalendar(year, month) {
                $.getJSON(`fetch_calendar_data.php?year=${year}&month=${month}`, function (data) {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    generateCalendar(year, month, data);
                });
            }

            // Generate calendar grid
            function generateCalendar(year, month, data) {
                const calendarContainer = $('#calendar');
                const daysInMonth = new Date(year, month, 0).getDate();
                const firstDay = new Date(year, month - 1, 1).getDay();

                const weekDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                const statuses = {};
                data.forEach(entry => {
                    statuses[entry.day] = {
                        status: entry.status,
                        name: entry.holiday_name,
                        description: entry.holiday_description,
                        checkIn: entry.check_in ? entry.check_in : '',
                        checkOut: entry.check_out ? entry.check_out : ''
                    };
                });

                let html = `<div class="calendar-grid">`;

                weekDays.forEach(day => html += `<div class="day-label">${day}</div>`);

                for (let i = 0; i < firstDay; i++) {
                    html += `<div class="empty"></div>`;
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    let dayClass = "working";
                    let tooltip = "";
                    let holidayName = "";
                    let holidayDescription = "";
                    let checkInOutText = "";

                    if (statuses[day]) {
                        const status = statuses[day].status;
                        dayClass = status.toLowerCase();
                        tooltip = statuses[day].name || status;
                        holidayName = statuses[day].name || "";
                        holidayDescription = statuses[day].description || "";
                        checkInOutText = `Check-in: ${statuses[day].checkIn} / Check-out: ${statuses[day].checkOut}`;
                    }

                    html += `<div class="day ${dayClass}"
                         title="${tooltip}\n${checkInOutText}"
                         data-day="${day}"
                         data-holiday-name="${holidayName}"
                         data-holiday-description="${holidayDescription}">
                         ${day}
                     </div>`;
                }

                html += `</div>`;
                calendarContainer.html(html);

                // Highlight current day and set cursor
                const currentDate = new Date();
                const currentDay = currentDate.getDate();
                const currentMonth = currentDate.getMonth(); // 0-based index for month
                const currentYear = currentDate.getFullYear();

                // Highlight the current day by adding 'current-day' class
                $(`.day[data-day="${currentDay}"]`).addClass("current-day");
            }

            // Update the year and month dropdown values based on current month and year
            function updateDropdowns() {
                // Update the year dropdown
                $("#year-select").val(currentYear);

                // Update the month dropdown (1-based month)
                $("#month-select").val(currentMonth + 1);
            }
        });
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


@endsection






   

   
</body>

</html>
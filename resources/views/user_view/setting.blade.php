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
    <!-- Main container with sidebar and content area -->
    <div class="main-container mx-">
        <!-- Sidebar for different settings components -->
        <div class="sidebar_main" id="sidebarMain">
            <div class="sidebar_internal">
                <!-- Top Section with Search Bar and Toggle -->
                <div class="sidebar_top">
                    <div class="sidebar_top_left">
                        <div class="Logo_main sidebar-search" id="logoMain">
                            <div class="search-bar">
                                <!-- Search input to filter settings -->
                                <input type="text" placeholder="Search Settings..." id="searchInput">
                            </div>
                        </div>
                    </div>
                    <div class="sidebar_top_right">
                        <div class="top_button_container">
                            <!-- Button to collapse/expand sidebar -->
                            <button type="button" class="top_button" id="collapseButton" onclick="toggleSidebar()">
                                <i class="fas fa-chevron-right" id="collapseIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Bottom with Settings Categories -->
                <div class="sidebar_bottom">
                    <div class="button-list" id="buttonList">
                        <!-- Setting option based on Permission -->
                        <?php if(in_array(11, $permission_array)): ?>
                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('calendarMaster')"
                                    data-setting="calendarMaster">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/calendar-icon.png') }}" alt="Calendar Master">
                                </div>
                                <span class="sidebar-button-text">Calendar Master</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <!-- Setting option based on Permission -->
                        <?php if(in_array(13, $permission_array)): ?>
                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('thoughtNews')"
                                    data-setting="thoughtNews">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/thought-icon.png') }}" alt="Thought & News">
                                </div>
                                <span class="sidebar-button-text">Thought of the Day/News & Events</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <!-- Setting option based on Permission -->
                        <?php if(in_array(12, $permission_array)): ?>
                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('employeeDetails')"
                                    data-setting="employeeDetails">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/employee-icon.png') }}" alt="Employee Details">
                                </div>
                                <span class="sidebar-button-text">Employee Details Edit</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <!-- Setting option based on Permission -->
                        <?php if(in_array(14, $permission_array)): ?>
                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('employeeSalary')"
                                    data-setting="employeeSalary">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/salary-icon.png') }}" alt="Employee Salary">
                                </div>
                                <span class="sidebar-button-text">Employee Salary</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('processSalary')"
                                    data-setting="processSalary">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/process-icon.png') }}" alt="Process Salary">
                                </div>
                                <span class="sidebar-button-text">Process Salary (2025-26)</span>
                            </button>
                        </div>

                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('leaveSummary')"
                                    data-setting="leaveSummary">
                                <div class="sidebar-icon">
                                    <img src="{{ asset('user_end/images/leave-icon.png') }}" alt="Leave Summary">
                                </div>
                                <span class="sidebar-button-text">Leave Summary</span>
                            </button>
                        </div> <!-- Leave Summary Button End -->
                    </div> <!-- Button List End -->
                </div> <!-- Sidebar Bottom End -->
            </div> <!-- Sidebar Internal End -->
        </div> <!-- Sidebar Main End -->

        <!-- Content Area -->
        <div class="content-area my-2 active" id="contentArea">
            <div class="setting-content" id="settingContent">
                <!-- Calendar Master Content (Default Open) -->
                <?php if(in_array(11, $permission_array)): ?>
                <div id="calendarMasterContent" class="setting-section active">
                    <h2>Calendar Master</h2>
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

                                <!-- Saturday Config  -->
                                <div id="saturdayConfig" style="display:none;" class="mx-3 my-2">
                                    <label>Select Saturday Offs:</label><br>
                                    <input type="checkbox" name="saturday_offs[]" value="1"> 1st Saturday
                                    <input type="checkbox" name="saturday_offs[]" value="2"> 2nd Saturday
                                    <input type="checkbox" name="saturday_offs[]" value="3"> 3rd Saturday
                                    <input type="checkbox" name="saturday_offs[]" value="4"> 4th Saturday
                                    <input type="checkbox" name="saturday_offs[]" value="5"> 5th Saturday
                                </div>

                                <!-- Holiday Selection  -->
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

                                <!-- Working Hours Container  -->
                                <div id="workingHoursContainer" style="display:none;">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="submit-btn px-3 py-1">Submit</button>
                            </form>
                        </div>
                <?php endif; ?>
                

            <!-- Thought of the Day -->
            <?php if(in_array(13,$permission_array)): ?>
            <div id="thoughtNewsContent" class="setting-section">
                    <h2>Thought of the Day/News & Events</h2>
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
                
            <?php endif; ?>
         
            <!-- Employee Edit -->
            <?php if(in_array(12, $permission_array)): ?>
            <div id="employeeDetailsContent" class="setting-section">
                    <h2>Employee Details Edit</h2>
                    <div class="content" id="employeeTableContainer">
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
                                    <!-- The user serial numbers were repeating from 1–10 twice, so I updated them to continue sequentially as 1, 2, 3 … n. (3823)-->
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
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
                <?php endif; ?>

                <?php if(in_array(14, $permission_array)): ?>
                <div id="employeeSalaryContent" class="setting-section">
                    <h2>Employee Salary</h2> 
                            <div class="content">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <!-- changed the table column name from edit to action -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        @foreach ($users_for_salary as $us)
                                            <tr>
                                                <input type="hidden" name="user_id" value="{{ $us->user_id }}">

                                                 <!-- used to send required backend data without showing it to the user -->
                                                <input type="hidden" name="trmplate_id" value="1">
                                                <input type="hidden" name="ctc" value="0">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $us->emp_employeeID }}</td>
                                                <td>{{ $us->user_name }}</td>
                                                
                                                <!-- display department name -->
                                                <td>{{ $us->department_name ?? 'N/A' }}</td>
                                                <!-- display designation name -->
                                                <td>{{ $us->designation_name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('salary.details.creation', $us->user_id) }}" class="icon-btn">
                                                        <i class="fa-solid fa-up-right-from-square"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{-- {{ $users_for_salary->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

             <!-- Process Salary -->
                <div id="processSalaryContent" class="setting-section">
                    <h2>Process Salary</h2>
                    <form action="{{ route('process_salary') }}" method="POST">
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



<!-- Leave Summary Section -->
<div id="leaveSummaryContent" class="setting-section">
    <h2>Leave Summary</h2>
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
                   <!-- <label for="start_date">Start Date:</label> -->
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()">
                    
                    <!-- <label for="end_date">End Date:</label> -->
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()">
            </form>     
        <!-- Leave Summary Table -->
            <div class="table-scroll-container">
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
        </div> <!-- Table Scroll Container End -->
        </div> <!-- Accordion Content End -->
   </div> <!-- Leave Summary Content End -->
</div> <!-- Setting Content End -->
</div> <!-- Content Area End -->
</div> <!-- Main Container End -->
</main> <!-- Main End -->

<script>
    // Calendar Master functionality for week off and holiday selection
    const saturdayCheckbox = document.getElementById('saturday');
    const saturdayConfig = document.getElementById('saturdayConfig');
       
       saturdayCheckbox.addEventListener('change', function() {
            saturdayConfig.style.display = this.checked ? 'block' : 'none';
        });
        // if user checks any specific saturday boxes, automatically ensure the main Saturday checkbox is checked
        document.querySelectorAll('input[name="saturday_offs[]"]').forEach(function(el) {
            el.addEventListener('change', function() {
                const anyChecked = document.querySelectorAll('input[name="saturday_offs[]"]:checked').length > 0;
                if (anyChecked && saturdayCheckbox) {
                    saturdayCheckbox.checked = true;
                    saturdayConfig.style.display = 'block';
                }
            });
        });
    

    // Sidebar collapse/expand functionality
    let sidebarCollapsed = false;
   
    function toggleSidebar() {
        sidebarCollapsed = !sidebarCollapsed;
        const sidebarMain = document.getElementById('sidebarMain');
        const sidebarTop = document.querySelector('.sidebar_top');
        const logoMain = document.getElementById('logoMain');
        const searchBar = document.querySelector('.search-bar');
        const searchInput = document.getElementById('searchInput');
        const collapseIcon = document.getElementById('collapseIcon');
        const buttonList = document.getElementById('buttonList');
        const sidebarButtons = document.querySelectorAll('.sidebar-button');
        const buttonTexts = document.querySelectorAll('.sidebar-button-text');
        const sidebarTopLeft = document.querySelector('.sidebar_top_left');
        const sidebarTopRight = document.querySelector('.sidebar_top_right');
        const topButtonContainer = document.querySelector('.top_button_container');
        const sidebarBottom = document.querySelector('.sidebar_bottom');

        if (sidebarCollapsed) {
            // Collapse sidebar to 75px width
            sidebarMain.style.width = '75px';
            sidebarMain.style.minWidth = '75px';
            
            // Hide search bar and logo completely
            if (logoMain) {
                logoMain.style.display = 'none';
            }
            if (searchBar) {
                searchBar.style.display = 'none';
            }
            if (searchInput) {
                searchInput.style.display = 'none';
            }
            if (sidebarTopLeft) {
                sidebarTopLeft.style.display = 'none';
            }
            
            // Adjust sidebar top to center button only
            if (sidebarTop) {
                sidebarTop.style.justifyContent = 'center';
                sidebarTop.style.alignItems = 'center';
                sidebarTop.style.padding = '10px 0';
            }
            
            // Center the collapse button
            if (sidebarTopRight) {
                sidebarTopRight.style.width = '100%';
                sidebarTopRight.style.display = 'flex';
                sidebarTopRight.style.justifyContent = 'center';
                sidebarTopRight.style.alignItems = 'center';
                sidebarTopRight.style.borderRadius = '30px 30px 0 0';
            }
            if (topButtonContainer) {
                topButtonContainer.style.padding = '10px';
                topButtonContainer.style.margin = '0 auto';
            }
            
            // Rotate collapse icon
            collapseIcon.style.transform = 'rotate(180deg)';
            
            // Adjust sidebar bottom for icons only
            if (sidebarBottom) {
                sidebarBottom.style.paddingTop = '5px';
            }
            
            // Adjust button list for icons only
            if (buttonList) {
                buttonList.style.borderRadius = '0px 0px 25px 25px';
                buttonList.style.paddingTop = '5px';
                buttonList.style.gap = '8px';
            }
            
            // Show only icons, hide text - properly centered
            sidebarButtons.forEach(btn => {
                btn.style.width = '60px';
                btn.style.height = '60px';
                btn.style.justifyContent = 'center';
                btn.style.alignItems = 'center';
                btn.style.padding = '0';
                btn.style.margin = '0 auto';
            });
            
            // Hide icon backgrounds when collapsed, show just icons
            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.style.margin = '0';
                icon.style.width = '50px';
                icon.style.height = '50px';
            });
            
            buttonTexts.forEach(text => {
                text.style.display = 'none';
            });
        } else {
            // Expand sidebar back
            sidebarMain.style.width = '22%';
            sidebarMain.style.minWidth = 'auto';
            
            // Restore sidebar top layout
            if (sidebarTop) {
                sidebarTop.style.justifyContent = 'space-between';
                sidebarTop.style.alignItems = 'flex-start';
                sidebarTop.style.padding = '0';
            }
            
            // Show search bar and logo
            if (logoMain) {
                logoMain.style.display = 'flex';
                logoMain.style.width = '75%';
                logoMain.style.height = '70px';
                logoMain.style.marginLeft = '10px';
                logoMain.style.marginRight = '10px';
            }
            if (searchBar) {
                searchBar.style.display = 'flex';
            }
            if (searchInput) {
                searchInput.style.display = 'block';
            }
            if (sidebarTopLeft) {
                sidebarTopLeft.style.display = 'block';
            }
            
            // Restore top right layout
            if (sidebarTopRight) {
                sidebarTopRight.style.width = '30%';
                sidebarTopRight.style.justifyContent = 'flex-end';
                sidebarTopRight.style.borderRadius = '45px 45px 45px 0';
            }
            if (topButtonContainer) {
                topButtonContainer.style.padding = '20px';
                topButtonContainer.style.margin = '0';
            }
            
            // Rotate collapse icon back
            collapseIcon.style.transform = 'rotate(0deg)';
            
            // Restore sidebar bottom
            if (sidebarBottom) {
                sidebarBottom.style.paddingTop = '0';
            }
            
            // Restore button list
            if (buttonList) {
                buttonList.style.borderRadius = '0px 25px 25px 25px';
                buttonList.style.paddingTop = '10px';
                buttonList.style.gap = '6px';
            }
            
            // Show text with icons - restore full layout
            sidebarButtons.forEach(btn => {
                btn.style.width = '98%';
                btn.style.height = 'auto';
                btn.style.justifyContent = 'flex-start';
                btn.style.alignItems = 'center';
                btn.style.padding = '10px 15px';
                btn.style.margin = '0';
            });
            
            // Restore icon sizes
            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.style.width = '50px';
                icon.style.height = '50px';
                icon.style.margin = '0';
            });
            
            buttonTexts.forEach(text => {
                text.style.display = 'inline';
            });
        }
    }

    // Select setting from sidebar
    function selectSetting(settingType) {
        // Remove active class from all buttons
        document.querySelectorAll('.sidebar-button').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to clicked button
        event.target.closest('.sidebar-button').classList.add('active');
        
        // Hide all setting sections
        document.querySelectorAll('.setting-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show selected setting section
        const selectedSection = document.getElementById(settingType + 'Content');
        if (selectedSection) {
            selectedSection.classList.add('active');
        }
    }

         // functionality for week off and holiday selection
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
                    if (holidayUpdate) holidayUpdate.style.display = "none";
                    if (workingHoursContainer) workingHoursContainer.style.display = "block";
                } else if (selectedOption === "holiday") {
                    if (weekOffSelection) weekOffSelection.style.display = "none";
                    holidayUpdate.style.display = "block";
                    if (workingHoursContainer) workingHoursContainer.style.display = "none";
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
        
        // Week Off Selection - Update Working Hours Fields
        const weekOffCheckboxes = document.querySelectorAll('input[name="weekoff[]"]');
        if (weekOffCheckboxes.length > 0) {
            weekOffCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateWorkingHoursFields();
                });
            });
        // Function to create working hours input fields based on selected week off days
        function updateWorkingHoursFields() {
            const weekOffDays = [];
            if (workingHoursContainer) {
                workingHoursContainer.innerHTML = "";
            }
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
            } else if (workingHoursContainer) {
                workingHoursContainer.innerHTML = "<p>No working days left. Please select week off days first.</p>";
            }
        }
        }

        // Thought form validation
        const thoughtDate = document.getElementById("thoughtDate");
        const thoughtDescription = document.getElementById("thoughtDescription");
        const submitThought = document.getElementById("submitThought");
        
        if (thoughtDate && submitThought) {
            thoughtDate.addEventListener("input", validateThoughtForm);
            thoughtDescription.addEventListener("input", validateThoughtForm);
        }
        // Function to validate thought form fields
        function validateThoughtForm() {
            const thoughtDate = document.getElementById("thoughtDate");
            const thoughtDescription = document.getElementById("thoughtDescription");
            const submitButton = document.getElementById("submitThought");
            submitButton.disabled = !(thoughtDate.value && thoughtDescription.value);
            
        }

    
        const date = document.getElementById("date");
        const title = document.getElementById("title");
        const description = document.getElementById("description");
        const eventStartDate = document.getElementById("event-start-date");
        const eventEndDate = document.getElementById("event-end-date");
        const location = document.getElementById("location");
        const submitNews = document.getElementById("submitNews");

        if (date && submitNews) {
            date.addEventListener("input", validateNewsForm);
            title.addEventListener("input", validateNewsForm);
            description.addEventListener("input", validateNewsForm);
            eventStartDate.addEventListener("input", validateNewsForm);
            eventEndDate.addEventListener("input", validateNewsForm);
            location.addEventListener("input", validateNewsForm);
        }
        // Function to validate news form fields
        function validateNewsForm() {
            const date = document.getElementById("date");
            const title = document.getElementById("title");
            const description = document.getElementById("description");
            const eventStartDate = document.getElementById("event-start-date");
            const eventEndDate = document.getElementById("event-end-date");
            const location = document.getElementById("location");
            const submitButton = document.getElementById("submitNews");
            
            submitButton.disabled = !(date.value && title.value && description.value && eventStartDate.value && eventEndDate.value && location.value);
            
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                performSearch();
            });
        }

        function performSearch() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;
            
            const term = (searchInput.value || '').trim().toLowerCase();
            const sidebarButtons = document.querySelectorAll('.sidebar-button');

            // Remove highlight classes only
            sidebarButtons.forEach(btn => btn.classList.remove('highlight'));

            if (!term) return;

            // Search in setting names and highlight matching settings
            sidebarButtons.forEach(button => {
                const settingNameEl = button.querySelector('.sidebar-button-text');
                if (settingNameEl) {
                    const settingName = settingNameEl.textContent.toLowerCase().trim();
                    if (settingName.includes(term)) {
                        button.classList.add('highlight');
                    }
                }
            });
        }
    });
    // Function to switch between Thought and News forms
    function switchForm(formType) {
        const thoughtForm = document.getElementById("thoughtForm");
        const newsForm = document.getElementById("newsForm");

            if (formType === "thought") {
                thoughtForm.style.display = "block";
                newsForm.style.display = "none";
                thoughtForm.classList.add("active");
                newsForm.classList.remove("active");
            } else if (formType === "news") {
                thoughtForm.style.display = "none";
                newsForm.style.display = "block";
                thoughtForm.classList.remove("active");
                newsForm.classList.add("active");
            }
        
    }

    // Fixed page reload issue on Settings page — prevented re-rendering after clicking Next using JavaScript(3823).
    document.addEventListener('click', function (e) {
        const link = e.target.closest('#employeeTableContainer .pagination a');
        if (!link) return;

        e.preventDefault();
        const container = document.getElementById('employeeTableContainer');
        if (!container) return;

        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.querySelector('#employeeTableContainer');
                if (newContainer) {
                    container.innerHTML = newContainer.innerHTML;
                }
            })
            .catch(err => console.error('Pagination load failed:', err));
    });
</script>
<script>
    // Wait until the DOM is fully loaded before executing the script
    document.addEventListener('DOMContentLoaded', function () {

    // Get all sidebar buttons
    const buttons = document.querySelectorAll('.sidebar-button');

    // Find first visible (permission-based) button
    const firstVisibleButton = Array.from(buttons)
        .find(btn => btn.offsetParent !== null);

    // Simulate click on first permitted button
    firstVisibleButton.click();

});
</script>


<style>
    /* Search highlight styles */
    .sidebar-button.highlight {
        background-color: #E0AFA0 !important;
        font-weight: bold !important;
    }
    
    /* Make top_button (sidebar collapse button) circular */
    .top_button {
        border-radius: 50% !important;
    }

    /* Setting section styles */
    .setting-section {
        display: none;
        padding: 20px;
    }
    /* Active setting section */
    .setting-section.active {
        display: block;
    }
    /* Dynamic form styles */
    .dynamic-form {
        display: none;
    }
    /* Active dynamic form */
    .dynamic-form.active {
        display: block;
    }
</style>

@endsection

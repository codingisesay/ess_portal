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
                                    <!-- Calendar Icon -->
                                    <i class="fa fa-calendar"></i>
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
                                    <!-- Thought Icon -->
                                    <i class="fa fa-lightbulb"></i>
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
                                    <!-- User Edit Icon -->
                                    <i class="fa fa-user-edit"></i>
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
                                    <!-- Money Bill Icon -->
                                    <i class="fa fa-money-bill-wave"></i>
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
                                    <!-- Salary Icon -->
                                    <i class="fa fa-cogs"></i>
                                </div>
                                <span class="sidebar-button-text">Process Salary (2025-26)</span>
                            </button>
                        </div>

                        <div class="dropdown-section">
                            <button class="sidebar-button" 
                                    onclick="selectSetting('leaveSummary')"
                                    data-setting="leaveSummary">
                                <div class="sidebar-icon">
                                    <!-- Calendar Check Icon -->
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <span class="sidebar-button-text">Leave Summary</span>
                            </button>
                        </div> <!-- Leave Summary Button End -->
                        <!-- Policy Management -->
                        <div class="dropdown-section">
                        <!-- Parent Button -->
                        <button class="sidebar-button" id="policyToggle">
                            <div class="sidebar-icon">
                                <i class="fa fa-file-alt"></i>
                                </div>
                                <span class="sidebar-button-text">Policy Management</span>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                                </button>
                                <!-- Sub Menu -->
                                <div class="submenu" id="policySubmenu">
                                <button class="sidebar-sub-button" onclick="showSection('createPolicyContent')">
                                 Create Policy Category
                                 </button>
                                 <button class="sidebar-sub-button" onclick="showSection('createHRPolicyContent')">
                                 Create HR Policy
                                 </button> 
                            </div> <!-- Sub Menu End -->
                        </div> <!-- Policy Management End -->

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
<!-- Create HR Policy Content -->
<div id="createHRPolicyContent" class="setting-section">
    <h2>Create HR Policy</h2>
    <div class="d-flex policy-header">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showHRPolicyForm(this)">Show Form</button>
            <button onclick="showHRPolicyTable(this)">Show Table</button>
        </div>
        
        <!-- Search Box with Icon (initially hidden) -->
        <div class="search-container" id="hrPolicySearchContainer" style="display: none;">
            <div class="search-box">
                <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="hrPolicySearchIcon">
                <input
                type="text"
                id="hrPolicyTableSearch"
                class="search-input"
                placeholder="Search By Title Or Category"
                data-search-input
                data-table-section="hrPolicyTableSection"
                data-no-results="noResults"
                />
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="hrPolicyFormSection">
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('save_hr_policy') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="text" id="policy_title" name="policy_title" class="form-control" required>
                        <label for="policy_title">Policy Title</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option disabled selected>Select</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Select Category</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="text" id="policy_content" name="policy_content" class="form-control" required>
                        <label for="policy_content">Policy Content</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="file" id="document" name="document" class="form-control">
                        <label for="document">Upload Document</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="file" id="icon" name="icon" class="form-control">
                        <label for="icon">Upload Icon</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="file" id="content_image" name="content_image" class="form-control">
                        <label for="content_image">Upload Content Image</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <select id="hr_status" name="status" class="form-control" required>
                            <option disabled selected>Select</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="hr_status">Status</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="create-btn policy-create-btn">Save Policy</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="hrPolicyTableSection" style="display: none;">
        <div class="table-scroll-container">
            @if($hr_policies && count($hr_policies) > 0)
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hr_policies as $policy)
                        @php
                            // Get category name
                            $categoryName = '';
                            foreach ($categories as $cat) {
                                if ($cat->id == $policy->policy_categorie_id) {
                                    $categoryName = $cat->name;
                                    break;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $policy->id }}</td>
                            <td>{{ $policy->policy_title }}</td>
                            <td>{{ $categoryName }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($policy->status) }}">
                                    {{ $policy->status }}
                                </span>
                            </td>
                            <td>
                                <button class="icon-btn edit-btn" 
                                        onclick="openHREditModal('{{ $policy->id }}', {
                                            id: '{{ $policy->id }}', 
                                            policy_title: '{{ addslashes($policy->policy_title) }}', 
                                            policy_categorie_id: '{{ $policy->policy_categorie_id }}', 
                                            status: '{{ $policy->status }}'
                                        })"
                                        data-tooltip="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($hr_policies instanceof \Illuminate\Pagination\LengthAwarePaginator && $hr_policies->hasPages())
            <div class="pagination-container mt-3">
                {{ $hr_policies->links() }}
            </div>
            @endif
            
            @else
            <div class="no-results">
                <i class="fas fa-inbox"></i>
                <p>No HR policies found</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for editing HR Policy -->
<div id="editHRPolicyModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editHRPolicyModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit HR Policy</h2>
        </header>
        <div class="w3-container">
            <form id="editHRPolicyForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="policy_id" id="editHRPolicyId">
                <div class="policy-form-group">
                    <input type="text" name="policy_title" id="editHRPolicyTitle" required>
                    <label for="editHRPolicyTitle">Policy Title</label>
                </div>
                <div class="policy-form-group">
                    <select name="category_id" id="editHRPolicyCategory" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="editHRPolicyCategory">Select Category</label>
                </div>
                <div class="policy-form-group">
                    <select name="status" id="editHRPolicyStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editHRPolicyStatus">Status</label>
                </div>
                <div class="policy-form-group">
                    <button class="create-btn1 policy-create-btn" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create Policy Category Content -->
<div id="createPolicyContent" class="setting-section">
    <h2>Create Policy Category</h2>
    <div class="d-flex policy-header">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showPolicyCategoryForm(this)">Show Form</button>
            <button onclick="showPolicyCategoryTable(this)">Show Table</button>
        </div>
        
        <!-- Search Box with Icon (initially hidden) -->
        <div class="search-container" id="policyCategorySearchContainer" style="display: none;">
            <div class="search-box">
                <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="policyCategorySearchIcon">
                <input
                    type="text"
                    id="policyCategoryTableSearch"
                    class="search-input"
                    placeholder="Search By Category Name"
                    data-search-input
                    data-table-section="policyCategoryTableSection"
                    data-no-results="noResults"
                />
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="policyCategoryFormSection">
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('save_policy_category') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <input type="text" id="category_name" name="category_name" class="form-control" required>
                        <label for="category_name">Category Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group policy-form-group">
                        <select id="status" name="status" class="form-control" required>
                            <option disabled selected>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="create-btn policy-create-btn">Save Category</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="policyCategoryTableSection" style="display: none;">
        <div class="table-scroll-container">
            @if($policy_categories && count($policy_categories) > 0)
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($policy_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($category->status) }}">
                                    {{ $category->status }}
                                </span>
                            </td>
                            <td>
                                <button class="icon-btn edit-btn" 
                                        onclick="openPolicyCategoryEditModal('{{ $category->id }}', {
                                            id: '{{ $category->id }}', 
                                            name: '{{ addslashes($category->name) }}', 
                                            status: '{{ $category->status }}'
                                        })"
                                        data-tooltip="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($policy_categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $policy_categories->hasPages())
            <div class="pagination-container mt-3">
                {{ $policy_categories->links() }}
            </div>
            @endif
            
            @else
            <div class="no-results">
                <i class="fas fa-inbox"></i>
                <p>No policy categories found</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for editing Policy Category -->
<div id="editPolicyCategoryModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editPolicyCategoryModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Policy Category</h2>
        </header>
        <div class="w3-container">
            <form id="editPolicyCategoryForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="category_id" id="editPolicyCategoryId">
                <div class="policy-form-group">
                    <input type="text" name="category_name" id="editPolicyCategoryName" required>
                    <label for="editPolicyCategoryName">Category Name</label>
                </div>
                <div class="policy-form-group">
                    <select name="status" id="editPolicyCategoryStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editPolicyCategoryStatus">Status</label>
                </div>
                <div class="policy-form-group">
                    <button class="create-btn1 policy-create-btn" type="submit">Save Changes</button>
                </div>
            </form>
        </div> 
    </div>        
</div> <!-- Edit Policy Category Modal End -->
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
                const dropdownArrow = btn.querySelector('.dropdown-arrow');
                // Hide dropdown arrows when sidebar is collapsed
                 if (dropdownArrow) {
                 dropdownArrow.style.display = 'none';
            }
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
<script>
// Dropdown toggle for Policy Management submenu
document.getElementById('policyToggle').addEventListener('click', function () {
    const submenu = document.getElementById('policySubmenu');
    this.classList.toggle('dropdown-open');

    if (submenu.style.display === 'flex') {
        submenu.style.display = 'none';
    } else {
        submenu.style.display = 'flex';
    }
});

/* Content switcher - Main function to show/hide setting sections */
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.setting-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Ensure policy submenu stays open
    document.getElementById('policySubmenu').style.display = 'flex';
}

// Policy Management sidebar active state handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle clicks on policy toggle button
    document.getElementById('policyToggle').addEventListener('click', function(e) {
        // Add active to this button
        this.classList.add('active');
    });
    
    // Handle clicks on policy sub-buttons
    document.querySelectorAll('.sidebar-sub-button').forEach(subBtn => {
        subBtn.addEventListener('click', function(e) {
            // Remove active from all sub-buttons
            document.querySelectorAll('.sidebar-sub-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active to clicked submenu
            this.classList.add('active');

            // Keep Policy Management active
            const policyToggle = document.getElementById('policyToggle');
            if (policyToggle) {
                policyToggle.classList.add('active');
            }

            // Keep submenu open
            const submenu = document.getElementById('policySubmenu');
            if (submenu) {
                submenu.style.display = 'flex';
            }
        });
    });
});
// HR Policy functions
document.addEventListener('DOMContentLoaded', function() {
    // Search box toggle functionality for HR Policy
    const hrSearchBox = document.querySelector('#hrPolicySearchContainer .search-box');
    const hrSearchIcon = document.getElementById('hrPolicySearchIcon');
    const hrSearchInput = document.getElementById('hrPolicyTableSearch');
    
    if (hrSearchIcon && hrSearchInput) {
        // Toggle search box on icon click
        hrSearchIcon.addEventListener('click', function() {
            hrSearchBox.classList.toggle('expanded');
            if (hrSearchBox.classList.contains('expanded')) {
                setTimeout(() => {
                    hrSearchInput.focus();
                }, 300);
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', function(event) {
            if (!hrSearchBox.contains(event.target) && hrSearchBox.classList.contains('expanded')) {
                hrSearchBox.classList.remove('expanded');
            }
        });
        
        // Prevent search box from closing when clicking inside it
        hrSearchInput.addEventListener('click', function(event) {
            event.stopPropagation();
        });
        
        // Handle search input
        hrSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#hrPolicyTableSection tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowMatches = false;
                
                // Skip the action column (last cell)
                for (let i = 0; i < cells.length - 1; i++) {
                    const cellText = cells[i].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        rowMatches = true;
                        break;
                    }
                }
                
                row.style.display = rowMatches ? '' : 'none';
            });
        });
    }
    
    // Show form by default for HR Policy
    showHRPolicyForm(document.querySelector('#createHRPolicyContent .toggle-buttons button:first-child'));
});

function showHRPolicyForm(clickedElement) {
    // Show form section and hide table section
    document.getElementById('hrPolicyFormSection').style.display = 'block';
    document.getElementById('hrPolicyTableSection').style.display = 'none';
    
    // Hide search container
    document.getElementById('hrPolicySearchContainer').style.display = 'none';
    
    // Collapse search box if it's expanded
    const hrSearchBox = document.querySelector('#hrPolicySearchContainer .search-box');
    if (hrSearchBox) {
        hrSearchBox.classList.remove('expanded');
    }
    
    updateHRActiveButton(clickedElement);
}

function showHRPolicyTable(clickedElement) {
    // Show table section and hide form section
    document.getElementById('hrPolicyFormSection').style.display = 'none';
    document.getElementById('hrPolicyTableSection').style.display = 'block';
    
    // Show search container when table is shown
    document.getElementById('hrPolicySearchContainer').style.display = 'block';
    
    updateHRActiveButton(clickedElement);
}
// 
function updateHRActiveButton(clickedElement) {
    const siblings = clickedElement.parentElement.children;
    for (let sibling of siblings) {
        sibling.classList.remove('active');
    }
    clickedElement.classList.add('active');
}

function openHREditModal(id, item) {
    document.getElementById('editHRPolicyId').value = id;
    document.getElementById('editHRPolicyTitle').value = item.policy_title;
    document.getElementById('editHRPolicyCategory').value = item.policy_categorie_id;
    document.getElementById('editHRPolicyStatus').value = item.status;
    
    // Dynamically set the form action with the correct ID
    const formAction = "{{ route('update_hr_policy', ['id' => ':id']) }}".replace(':id', item.id);
    document.getElementById('editHRPolicyForm').action = formAction;

    document.getElementById('editHRPolicyModal').style.display = 'block';
}

// Handle HR Policy pagination without page reload
document.addEventListener('click', function (e) {
    const link = e.target.closest('#hrPolicyTableSection .pagination a');
    if (!link) return;

    e.preventDefault();

    fetch(link.href, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const newTable = doc.querySelector('#hrPolicyTableSection');
        if (newTable) {
            document.getElementById('hrPolicyTableSection').innerHTML = newTable.innerHTML;
            attachHRSearch();
        }
    })
    .catch(err => console.error('Pagination failed:', err));
});

// Policy Category functions
document.addEventListener('DOMContentLoaded', function() {
    // Search box toggle functionality for Policy Category
    const policyCategorySearchBox = document.querySelector('#policyCategorySearchContainer .search-box');
    const policyCategorySearchIcon = document.getElementById('policyCategorySearchIcon');
    const policyCategorySearchInput = document.getElementById('policyCategoryTableSearch');
    
    if (policyCategorySearchIcon && policyCategorySearchInput) {
        // Toggle search box on icon click
        policyCategorySearchIcon.addEventListener('click', function() {
            policyCategorySearchBox.classList.toggle('expanded');
            if (policyCategorySearchBox.classList.contains('expanded')) {
                setTimeout(() => {
                    policyCategorySearchInput.focus();
                }, 300);
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', function(event) {
            if (!policyCategorySearchBox.contains(event.target) && policyCategorySearchBox.classList.contains('expanded')) {
                policyCategorySearchBox.classList.remove('expanded');
            }
        });
        
        // Prevent search box from closing when clicking inside it
        policyCategorySearchInput.addEventListener('click', function(event) {
            event.stopPropagation();
        });
        
        // Handle search input
        policyCategorySearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#policyCategoryTableSection tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowMatches = false;
                
                // Skip the action column (last cell)
                for (let i = 0; i < cells.length - 1; i++) {
                    const cellText = cells[i].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        rowMatches = true;
                        break;
                    }
                }
                
                row.style.display = rowMatches ? '' : 'none';
            });
        });
    }
    
    // Show form by default for Policy Category
    const policyCategoryFirstButton = document.querySelector('#createPolicyContent .toggle-buttons button:first-child');
    if (policyCategoryFirstButton) {
        showPolicyCategoryForm(policyCategoryFirstButton);
    }
});

function showPolicyCategoryForm(clickedElement) {
    // Show form section and hide table section
    document.getElementById('policyCategoryFormSection').style.display = 'block';
    document.getElementById('policyCategoryTableSection').style.display = 'none';
    
    // Hide search container
    document.getElementById('policyCategorySearchContainer').style.display = 'none';
    
    // Collapse search box if it's expanded
    const policyCategorySearchBox = document.querySelector('#policyCategorySearchContainer .search-box');
    if (policyCategorySearchBox) {
        policyCategorySearchBox.classList.remove('expanded');
    }
    
    updatePolicyCategoryActiveButton(clickedElement);
}

function showPolicyCategoryTable(clickedElement) {
    // Show table section and hide form section
    document.getElementById('policyCategoryFormSection').style.display = 'none';
    document.getElementById('policyCategoryTableSection').style.display = 'block';
    
    // Show search container when table is shown
    document.getElementById('policyCategorySearchContainer').style.display = 'block';
    
    updatePolicyCategoryActiveButton(clickedElement);
}
function updatePolicyCategoryActiveButton(clickedElement) {
    const siblings = clickedElement.parentElement.children;
    for (let sibling of siblings) {
        sibling.classList.remove('active');
    }
    clickedElement.classList.add('active');
}
// Form is shown by default via the first DOMContentLoaded listener
function openPolicyCategoryEditModal(id, item) {
    document.getElementById('editPolicyCategoryId').value = id;
    document.getElementById('editPolicyCategoryName').value = item.name;
    document.getElementById('editPolicyCategoryStatus').value = item.status;
    
    // Dynamically set the form action with the correct ID
    const formAction = "{{ route('update_policy_category', ['id' => ':id']) }}".replace(':id', item.id);
    document.getElementById('editPolicyCategoryForm').action = formAction;

    document.getElementById('editPolicyCategoryModal').style.display = 'block';
}
// Handle Policy Category pagination without page reload
document.addEventListener('click', function (e) {
    const link = e.target.closest('#policyCategoryTableSection .pagination a');
    if (!link) return;

    e.preventDefault();

    fetch(link.href, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const section = doc.querySelector('#policyCategoryTableSection');

        if (section) {
            document.getElementById('policyCategoryTableSection').innerHTML =
                section.innerHTML;
            attachPolicyCategoryTableEvents(); // keep functionality
        }
    })
    .catch(err => console.error('Policy Category pagination failed:', err));
});

// Ensure the section shows properly when selected from sidebar
function showSection(sectionId) {
    document.querySelectorAll('.setting-section').forEach(section => {
        section.classList.remove('active');
    });

    document.getElementById(sectionId).classList.add('active');
    
    // Ensure submenu stays open for policy sections
    const policySubmenu = document.getElementById('policySubmenu');
    if (policySubmenu && (sectionId === 'createPolicyContent' || sectionId === 'createHRPolicyContent')) {
        policySubmenu.style.display = 'flex';
    }
    
    // Initialize the correct view for policy category
    if (sectionId === 'createPolicyContent') {
        const firstButton = document.querySelector('#createPolicyContent .toggle-buttons button:first-child');
        if (firstButton) {
            showPolicyCategoryForm(firstButton);
        }
    }
}
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

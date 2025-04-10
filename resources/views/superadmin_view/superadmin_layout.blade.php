

<?php
$name = Auth::guard('superadmin')->user()->name;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Superadmin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_sidebar.css') }}">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script> 
    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
    <link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="body">
    <!-- Top container -->
    <a href="{{ route('superadmin.logout') }}" class="logout-button">Logout</a>
    <script>
        var successMessage = @json(session('success'));
        var errorMessage = @json(session('error'));
    </script>
    
    <!-- Sidebar/menu -->
    <nav class="sidebar" id="mySidebar">
        <div class="sidebar-header"> 
            <div class="logo">
                <h5><strong>Company Name</strong></h5>
            </div>
            <span onclick="toggleSidebar()">
        <x-icon id="sidebar-icon" name="headerarrow"></x-icon>
    </span> 
        </div>
        <div class="sidebar-content">
            <ul class="nav-list">
                <!-- Organisation Configuration --> 
                <li id="orgConfigLi">
                    <strong onclick="toggleDropdown('orgConfigDropdown', this)">
                        <strong>  
                        <x-icon name="building" />&nbsp;&nbsp;<lable>Organisation&nbsp;Configuration</lable>&nbsp;&nbsp;&nbsp;</strong>
                        <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow" class="dropdown-arrow">
                    </strong>
                    <ul id="orgConfigDropdown">
                        <li><a href="{{ route('create_user') }}" class="{{ request()->routeIs('create_user') ? 'active' : '' }}">Create User</a></li>
                        <li><a href="{{ route('create_branch_form') }}" class="{{ request()->routeIs('create_branch_form') ? 'active' : '' }}">Create Branch</a></li>
                        <li><a href="{{ route('create_department_form') }}" class="{{ request()->routeIs('create_department_form') ? 'active' : '' }}">Create Department</a></li>
                        <li><a href="{{ route('create_designation_form') }}" class="{{ request()->routeIs('create_designation_form') ? 'active' : '' }}">Create Designation</a></li>
                    </ul>
                </li>

                <!-- Policy Management -->
                <li id="policyManagementLi">
                    <strong onclick="toggleDropdown('policyManagementDropdown', this)">
                        <strong>
                        <x-icon name="policy" />&nbsp;<lable> Policy Management</lable></strong>
                        <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow" class="dropdown-arrow">
                    </strong>
                    <ul id="policyManagementDropdown">
                        <li><a href="{{ route('create_policy_category') }}" class="{{ request()->routeIs('create_policy_category') ? 'active' : '' }}">Create Policy Category</a></li>
                        <li><a href="{{ route('create_hr_policy') }}" class="{{ request()->routeIs('create_hr_policy') ? 'active' : '' }}">Create HR Policy</a></li>
                        <li><a href="{{ route('create_policy_time_slot') }}" class="{{ request()->routeIs('create_policy_time_slot') ? 'active' : '' }}">Leave Policy Slot</a></li>
                        <li><a href="{{ route('create_policy_type') }}" class="{{ request()->routeIs('create_policy_type') ? 'active' : '' }}">Leave Policy Type</a></li>
                        <li><a href="{{ route('create_policy') }}" class="{{ request()->routeIs('create_policy') ? 'active' : '' }}">Leave Policy Creation</a></li>
                        <li><a href="{{ route('employee_policy') }}" class="{{ request()->routeIs('employee_policy') ? 'active' : '' }}">Leave Emp Policy</a></li>
                        <li><a href="{{ route('process_leave_policy') }}" class="{{ request()->routeIs('process_leave_policy') ? 'active' : '' }}">Process Leave Cycle</a></li>
                    </ul>
                </li>

                <!-- Salary Management -->
                <li id="salaryManagementLi">
                    <strong onclick="toggleDropdown('salaryManagementDropdown', this)">
                        <strong>
                        <x-icon name="salary" />&nbsp;<lable> Salary Management</lable></strong>
                        <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow" class="dropdown-arrow">
                    </strong>
                    <ul id="salaryManagementDropdown">
                        <li><a href="{{ route('salary_template_form') }}" class="{{ request()->routeIs('salary_template_form') ? 'active' : '' }}">Create Salary Templates</a></li>
                        <li><a href="{{ route('create_salary_components') }}" class="{{ request()->routeIs('create_salary_components') ? 'active' : '' }}">Salary Template Components</a></li>
                    </ul>
                </li>

                <!-- Tax Management -->
                <li id="taxManagementLi">
                    <strong onclick="toggleDropdown('taxManagementDropdown', this)">
                        <strong>
                        <x-icon name="tax" />&nbsp;<lable> Tax Management</lable></strong>
                        <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow" class="dropdown-arrow">
                    </strong>
                    <ul id="taxManagementDropdown">
                        <li><a href="{{ route('tax_cycle') }}" class="{{ request()->routeIs('tax_cycle') ? 'active' : '' }}">Tax Cycle</a></li>
                        <li><a href="{{ route('taxes') }}" class="{{ request()->routeIs('taxes') ? 'active' : '' }}">Taxes</a></li>
                    </ul>
                </li>

                <!-- Settings -->
                <li id="settingsLi">
                    <strong onclick="toggleDropdown('settingsDropdown', this)">
                        <strong>
                        <x-icon name="setting" />&nbsp;<lable> Settings</lable></strong>
                        <img src="{{ asset('user_end/images/arrow-right.svg') }}" alt="arrow" class="dropdown-arrow">
                    </strong>
                    <ul id="settingsDropdown">
                        <li><a href="{{ route('load_mail_config_form') }}" class="{{ request()->routeIs('load_mail_config_form') ? 'active' : '' }}">Mail Settings</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <img width='100px' src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" class="stpl_logo_icon1" alt="STPL Logo">
        <img width='40px' src="{{ asset('user_end/images/STPLLogo.png') }}" alt="STPL Logo" class="stpl_logo_icon2"> 
        <div class="sidebar-footer">
        <img width='35px' class="help_footer_icon" src="{{ asset('admin_end/images/support.png') }}" alt=""> 
            <div class="sidebar_footer_text">
                <strong>Need Help?</strong> <br>
                <small>Go to Help Center
                    <i class="bi bi-arrow-right"></i>
                </small>
            </div>
        </div>
    </nav>

    @yield('content')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize dropdown states from localStorage
            const dropdownIds = [
                'orgConfigDropdown',
                'policyManagementDropdown',
                'salaryManagementDropdown',
                'taxManagementDropdown',
                'settingsDropdown'
            ];
            
            dropdownIds.forEach(id => {
                const isOpen = localStorage.getItem(`${id}-state`) === 'open';
                const dropdown = document.getElementById(id);
                const parentLi = dropdown.parentElement;
                const arrow = parentLi.querySelector('.dropdown-arrow');
                
                if (isOpen) {
                    dropdown.style.display = 'block';
                    arrow.classList.add('rotated');
                    parentLi.classList.add('active');
                } else {
                    dropdown.style.display = 'none';
                    arrow.classList.remove('rotated');
                    parentLi.classList.remove('active');
                }
            });
            
            // Highlight active link and open parent dropdown
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-list a');
            
            navLinks.forEach(link => {
                if (link.classList.contains('active')) {
                    // Open the parent dropdown if not already open
                    const dropdown = link.closest('ul');
                    if (dropdown && dropdown.style.display !== 'block') {
                        const dropdownId = dropdown.id;
                        const parentLi = dropdown.parentElement;
                        const arrow = parentLi.querySelector('.dropdown-arrow');
                        
                        dropdown.style.display = 'block';
                        arrow.classList.add('rotated');
                        parentLi.classList.add('active');
                        localStorage.setItem(`${dropdownId}-state`, 'open');
                    }
                }
            });
        });
        
        function toggleDropdown(id, element) {
            const dropdown = document.getElementById(id);
            const arrow = element.querySelector('.dropdown-arrow');
            const parentLi = dropdown.parentElement;
            
            if (dropdown.style.display === 'none' || !dropdown.style.display) {
                dropdown.style.display = 'block';
                arrow.classList.add('rotated');
                parentLi.classList.add('active');
                localStorage.setItem(`${id}-state`, 'open');
            } else {
                dropdown.style.display = 'none';
                arrow.classList.remove('rotated');
                parentLi.classList.remove('active');
                localStorage.setItem(`${id}-state`, 'closed');
            }
        }
    </script>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById("mySidebar");
    const icon = document.getElementById("sidebar-icon");

    // Toggle the sidebar's collapsed state
    sidebar.classList.toggle("collapsed");

    // Toggle the icon between right arrow and left arrow
    if (sidebar.classList.contains("collapsed")) {
        icon.setAttribute("name", "rightarrow");
    } else {
        icon.setAttribute("name", "leftarrow");
    }
}

    </script>
</body>
</html>
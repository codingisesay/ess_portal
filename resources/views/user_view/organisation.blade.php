@extends('user_view.header')
@section('content')
<?php
// $user = Auth::user();
// dd($user);
// dd($employees_login);

// exit();
function renderEmployeeNode($employee) {
    $hasSubordinates = !empty($employee->subordinates);
    ob_start();
    ?>
    <li>
        <?php if ($hasSubordinates): ?>
            <!-- Display the toggle button for employees with subordinates -->
            <button class="toggle-button" data-user-id="<?= $employee->user_id ?>" onclick="toggleChildren(this)">
                +
            </button>
        <?php else: ?> 
        <?php endif; ?>

        <span onclick="displayEmployeeDetails(
            '<?= $employee->user_id ?>',
            '<?= $employee->employee_name ?>', 
            '<?= $employee->designation ?>',
            '<?= $employee->reporting_manager_name ?>',
            '<?= $employee->department ?>',
            '<?= $employee->branch_name ?>',
            '<?= $employee->offical_phone_number ?>',
            '<?= $employee->alternate_phone_number ?>',
            '<?= $employee->offical_email_address ?>',
            '<?= $employee->emergency_contact_person ?>',
            '<?= $employee->emergency_contact_number ?>',
            '<?= !empty($employee->profile_image) ? asset('storage/' . $employee->profile_image) : asset('storage/user_profile_image/Oqr4VRqo7RpQxnmiZCh12zybbcdsyUin2FhAKD3O.jpg') ?>',
            '<?= $employee->permanent_address ?>',
            '<?= $employee->correspondance_address ?>'
        )">
            <?php 
            // Gender-specific image display
            if ($employee->gender == 'Male') {
                echo '<img src="' . asset('user_end/images/man2.png') . '" alt="Male" style="width:18px; height:18px; margin-right: 5px;">';
            } elseif ($employee->gender == 'Female') {
                echo '<img src="' . asset('user_end/images/woman.png') . '" alt="Female" style="width:18px; height:18px; margin-right: 5px;">';
            } else {
                echo '<img src="' . asset('user_end/images/male-and-female.png') . '" alt="Gender Neutral" style="width:18px; height:18px; margin-right: 5px;">'; // You can use a gender-neutral icon here if needed
            }
            ?>
            <?= $employee->employee_name ?>
        </span>
        <?php if ($hasSubordinates): ?>
            <ul data-manager-id="<?= $employee->user_id ?>" style="display: block;">
                <?php foreach ($employee->subordinates as $subordinate) {
                    echo renderEmployeeNode($subordinate);
                } ?>
            </ul>
        <?php endif; ?>
    </li>
    <?php
    return ob_get_clean();
}
?>
<?php 
error_reporting(0);
?>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- {{-- <title>Organisation Chart</title> --}} -->
    <link rel="icon" href= "../resource/image/common/STPLLogo butterfly.png" />
    <link rel="stylesheet" href="{{ asset('/user_end/css/organisation.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

 
<div class="mx-4 mt-3">
    <div class="header mb-4">
        <!-- <h4>Organization Hierarchy</h4> -->
        <div class="ds-pill">
            <button id="switchOrg" class="ds-option active" type="button" aria-pressed="true" onclick="changeChartView('vertical')">
                <span class="ds-icon ds-icon-org" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"></path>
                    </svg>
                </span>
                <span>Vertical</span>
            </button>
            <button id="switchMgr" class="ds-option" type="button" aria-pressed="false" onclick="changeChartView('horizontal')">
                <span class="ds-icon ds-icon-mgr" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v6h3a2 2 0 0 1 2 2v8h-4v-5h-2v5H7v-5H5v5H3Zm6-7H7v2h2v-2Zm0-4H7v2h2V10Zm4 4h-2v2h2v-2Zm0-4h-2v2h2V10Zm0-4H7v2h6V6Z"></path>
                    </svg>
                </span>
                <span>Horizontal</span>
            </button>
        </div>
        <div class="search-bar-container">
            <input type="text" id="search-bar" placeholder="Search Employee Name..." onkeyup="highlightEmployee()">
            <span class="search-icon"> <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon"></span>
        </div> 
        </div>

        <!-- Modal to show Horizontal Organization Chart -->
                <div class="modal fade" id="horizontalChartModal" tabindex="-1" aria-labelledby="horizontalChartModalLabel" aria-hidden="true" data-bs-backdrop="true">
                    <div class="modal-dialog modal-xl" style="max-width:1200px; width:90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="horizontalChartModalLabel">Horizontal Organization Chart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="horizontal-modal-body">
                        <div class="text-center py-4" id="horizontal-modal-loading">Loading chart…</div>
                    </div>
                </div>
            </div>
        </div>

        <div class=" row">  
        <div class="col-md-4 my-2">
            <div class="employee-list">
                <ul class="tree">
                    @foreach ($employeeHierarchy as $employee)
                        {!! renderEmployeeNode($employee) !!}
                    @endforeach
                </ul>
            </div>  
        </div>
            <div class="col-md-8 "> 
                <div class="employee-details row">  
                    <div class="col-md-4 my-2">
                        <div class="left">  
                            @include('user_view.employment_details_top')
                        </div> 
                    </div>
                    <div class="col-md-8 my-2">
                        <div class="right"> 
                            <!-- Include employment details section -->
                            @include('user_view.employment_details_section')
                        </div>
                    </div>

                </div>  
            </div>
        </div>
</div>

</div>

<script>
    // Make employeeGoals available in JS
    let employeeGoals = @json($employeeGoals);
    // Logged-in employee ID
    let loggedInUserId = "{{ $employees_login->user_id }}";
</script>

<script>  
    // Function to toggle s of employee children  
    // function toggleChildren(button) {
    //     const userId = button.getAttribute('data-user-id');
    //     const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
    //     if (childrenContainer) {
    //         const isVisible = childrenContainer.style.display === "block";
    //         childrenContainer.style.display = isVisible ? "none" : "block";
    //         button.textContent = isVisible ? "+" : "-";
    //     }
    // }
    document.addEventListener('DOMContentLoaded', function() {
    // Find all buttons that control subordinates visibility
    const buttons = document.querySelectorAll('[data-user-id]');
    
    buttons.forEach(button => {
        const userId = button.getAttribute('data-user-id');
        const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
        
        // Check the initial visibility of the ul (subordinates list)
        if (childrenContainer && childrenContainer.style.display === "block") {
            // If it's visible, set the button text to "-"
            button.textContent = "-";
        }
    });
    });

    function toggleChildren(button) {
        const userId = button.getAttribute('data-user-id');
        const childrenContainer = document.querySelector(`ul[data-manager-id="${userId}"]`);
        if (childrenContainer) {
            const isVisible = childrenContainer.style.display === "block";
            childrenContainer.style.display = isVisible ? "none" : "block"; // Toggle visibility
            button.textContent = isVisible ? "+" : "-"; // Change button text
        }
    }



        function displayEmployeeDetails(userId, name, designation, manager, department, city, phone, alternatephone, email, contactperson, contactnumber, profileImage, permanentAddress, correspondanceAddress) {  
        document.getElementById('emp-name').textContent = name;  
        document.getElementById('emp-designation').textContent = designation;  
        // document.getElementById('emp-no').textContent = empNo;  
        document.getElementById('emp-manager').textContent = manager;  
        document.getElementById('emp-department').textContent = department;  
        document.getElementById('emp-city').textContent = city;  
        document.getElementById('emp-phone').textContent = phone;  
        document.getElementById('emp-alternate-phone').textContent = alternatephone;
        document.getElementById('emp-email').textContent = email;
        document.getElementById('emp-permanent-address').textContent = permanentAddress;
        document.getElementById('emp-correspondance-address').textContent = correspondanceAddress;
        document.getElementById('emp-contactperson').textContent = contactperson;
        document.getElementById('emp-contactnumber').textContent = contactnumber;
        // Update the profile image
        document.getElementById('profile-image').src = profileImage || '{{ asset('storage/' .$profileimahe) }}';
        // ✅ Update goals dynamically
    let goalsContainer = document.getElementById('emp-goals');
    goalsContainer.innerHTML = "";

    let goalsToDisplay = employeeGoals[userId] || [];
    
    if (goalsToDisplay.length > 0) {
    let accordionHTML = `<div class="custom-accordion" id="goalsAccordion_${userId}">`;

    goalsToDisplay.forEach((goal, index) => {
        const panelId = `panel_${userId}_${index}`;
        const title = goal.title ?? 'Untitled Goal';
        const description = goal.description ?? 'No description available';
        const startDate = goal.start_date ?? '—';
        const endDate = goal.end_date ?? '—';

        accordionHTML += `
            <div class="accordion-item">
                <div class="accordion-header" data-target="${panelId}">
                    <span><i class="fas fa-bullseye me-2 text-primary"></i> ${title}</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="accordion-panel" id="${panelId}">
                    <p><strong>Description:</strong> ${description}</p>
                    <p><strong>Timeline:</strong> ${startDate ? new Date(startDate).toLocaleDateString('en-GB') : '—'} → ${endDate ? new Date(endDate).toLocaleDateString('en-GB') : '—'}</p>
                </div>
            </div>
        `;
    });

    accordionHTML += `</div>`;
    goalsContainer.innerHTML = accordionHTML;

    // Add toggle functionality
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const panel = document.getElementById(header.getAttribute('data-target'));
            const isOpen = panel.classList.contains('open');
            
            // Close all panels
            document.querySelectorAll('.accordion-panel').forEach(p => p.classList.remove('open'));
            document.querySelectorAll('.accordion-header .arrow').forEach(a => a.textContent = '▼');

            if (!isOpen) {
                panel.classList.add('open');
                header.querySelector('.arrow').textContent = '▲';
            }
        });
    });

} else {
    goalsContainer.innerHTML = "<p class='text-muted mb-0'>No goals assigned</p>";
}

    }

        function highlightEmployee() {  
            const searchQuery = document.getElementById('search-bar').value.toLowerCase();  
            const employees = document.querySelectorAll('.tree span');  

            employees.forEach(employee => {  
                // Highlight matching names or remove highlight  
                if (searchQuery && employee.textContent.toLowerCase().includes(searchQuery)) {  
                    employee.classList.add('highlight');  
                } else {  
                    employee.classList.remove('highlight');  
                }  
            });  
        }  

        // Function to change chart view
        function changeChartView(view) {
            const switchOrg = document.getElementById('switchOrg');
            const switchMgr = document.getElementById('switchMgr');
            
            if (view === 'horizontal') {
                switchOrg.classList.remove('active');
                switchMgr.classList.add('active');
                openHorizontalModal();
            } else {
                resetToggleToVertical();
                // Close modal if open
                const modal = document.getElementById('horizontalChartModal');
                if (modal) {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }
            }
        }

        // Function to reset toggle to Vertical
        function resetToggleToVertical() {
            const switchOrg = document.getElementById('switchOrg');
            const switchMgr = document.getElementById('switchMgr');
            
            switchOrg.classList.add('active');
            switchMgr.classList.remove('active');
        }

        // Open modal and load horizontal chart HTML via AJAX
        async function openHorizontalModal() {
            const modalEl = document.getElementById('horizontalChartModal');
            const modalBody = document.getElementById('horizontal-modal-body');
            const loading = document.getElementById('horizontal-modal-loading');

            // Add event listener for when the modal is hidden
            modalEl.addEventListener('hidden.bs.modal', function () {
                resetToggleToVertical();
            });

            // show bootstrap modal
            const ModalCtor = (window.bootstrap && window.bootstrap.Modal) ? window.bootstrap.Modal : null;
            let modalInstance = null;
            // ensure modal lives under document.body so Bootstrap backdrop covers full page (including header)
            try {
                if (modalEl && modalEl.parentElement !== document.body) {
                    document.body.appendChild(modalEl);
                }
            } catch (err) { /* ignore */ }

                if (ModalCtor) {
                // increase z-index to be above any header/navbar
                modalEl.style.zIndex = '99999';
                modalInstance = ModalCtor.getOrCreateInstance(modalEl, { backdrop: true, focus: true });
                modalInstance.show();
            } else {
                // fallback: show modal and create backdrop
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.style.zIndex = '99999';
                const back = document.createElement('div'); back.className = 'modal-backdrop fade show'; back.style.zIndex='99990'; document.body.appendChild(back);
            }

            if (modalBody) {
                modalBody.innerHTML = '<div class="text-center py-4">Loading chart…</div>';
            }

            try {
                const res = await fetch("{{ route('user.view.horizontal.organisation') }}", { credentials: 'same-origin' });
                if (!res.ok) throw new Error('Failed to load horizontal chart');
                const html = await res.text();

                // Parse returned HTML and try to extract the chart container
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Prefer the element with class 'scroll-container' so horizontal CSS rules apply.
                let fragment = doc.querySelector('.scroll-container') || doc.getElementById('employee-tree') || doc.querySelector('.tree');

                if (fragment && modalBody) {
                    modalBody.innerHTML = '';

                    // If fragment is the inner .tree (without .scroll-container), wrap it so CSS selectors apply
                    if (!fragment.classList.contains('scroll-container') && fragment.classList.contains('tree')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'scroll-container';
                        wrapper.appendChild(fragment.cloneNode(true));
                        modalBody.appendChild(wrapper);
                    } else {
                        modalBody.appendChild(fragment.cloneNode(true));
                    }

                    // ensure modal body has enough height for horizontal layout to render
                    modalBody.style.minHeight = '70vh';
                    modalBody.style.overflow = 'auto';

                    // initialize simple behaviors inside modal
                    initHorizontalModalScripts(modalBody);
                } else if (modalBody) {
                    // fallback: inject entire response (may include extra markup)
                    modalBody.innerHTML = html;
                    modalBody.style.minHeight = '70vh';
                    modalBody.style.overflow = 'auto';
                    initHorizontalModalScripts(modalBody);
                }

            } catch (err) {
                console.error(err);
                if (modalBody) modalBody.innerHTML = '<div class="text-danger">Could not load chart.</div>';
            }
        }

        // Wire up basic toggle/search behaviors for content injected into modalBody
        function initHorizontalModalScripts(container) {
            // container can be document or an element
            const root = container || document;

            // Toggle visibility for items that have nested lists
            root.querySelectorAll('.employee').forEach(emp => {
                const profile = emp.querySelector('.profile-container') || emp.querySelector('.employee-box') || emp;
                const childUl = emp.querySelector('ul');
                if (profile && childUl) {
                    profile.style.cursor = 'pointer';
                    profile.addEventListener('click', function (e) {
                        e.preventDefault();
                        childUl.style.display = (childUl.style.display === 'none') ? 'block' : 'none';
                    });
                }
            });

            // Ensure search in main page filters modal content as well
            const searchInput = document.getElementById('search-bar');
            if (searchInput) {
                searchInput.removeEventListener('input', highlightEmployee);
                searchInput.addEventListener('input', highlightEmployee);
            }
        }

        // Set default view and display employee details on load
    window.onload = function() {  
        // Default to vertical view (toggle off)  

        // Get the employee details from Laravel session
        const empUserId = "{{ $employees_login->user_id }}";         // Must be first (used for goals)
        const empName = "{{ $employees_login->employee_name }}";
        const empDesignation = "{{ $employees_login->designation }}";
        const empNo = "{{ $employees_login->employee_no }}";
        const empManager = "{{ $employees_login->reporting_manager_name }}"; // Ensure this is the manager's name
        const empDepartment = "{{ $employees_login->department }}";
        const empCity = "{{ $employees_login->branch_name }}";  
        const empPhone = "{{ $employees_login->offical_phone_number }}";
        const empAlternatephone = "{{ $employees_login->alternate_phone_number }}";
        const empEmail = "{{ $employees_login->offical_email_address }}";
        const permanentAddress = "{{ $employees_login->permanent_address }}";
        const correspondanceAddress = "{{ $employees_login->correspondance_address }}";
        const empContactperson = "{{ $employees_login->emergency_contact_person }}";
        const empContactnumber = "{{ $employees_login->emergency_contact_number }}";
        // const profileImage = "{{ asset('storage/' .$profileimahe) }}"; // Get the profile image from session
    // const profileImage = "{{ !empty($employees_login->profile_image) ? asset('storage/' . $employees_login->profile_image) : asset('storage/user_profile_image/default.jpg') }}";
        const profileImage = "{{ !empty($employees_login->profile_image) ? asset('storage/' . $employees_login->profile_image) : '' }}";
        // Call the function to display the logged-in employee details
        displayEmployeeDetails(empUserId,empName, empDesignation, empManager, empDepartment, empCity, empPhone, empAlternatephone, empEmail, empContactperson, empContactnumber, profileImage, permanentAddress, correspondanceAddress);
    };
</script> 

<style>
    /* Pill Style Toggle Switch */
    .ds-pill {
        display: inline-flex;
        background-color: #f1f1f1;
        border-radius: 20px;
        padding: 2px;
        margin-right: 15px;
    }
    
    .ds-option {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #666;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .ds-option:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .ds-option.active {
        background-color: #fff;
        color: #1a73e8;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
    }
    
    .ds-option .ds-icon {
        display: inline-flex;
        align-items: center;
        margin-right: 8px;
    }
    
    .ds-option svg {
        width: 16px;
        height: 16px;
    }
    
    .custom-accordion {
    border: 1px solid #ccc;
    border-radius: 4px;
}

.accordion-item {
    border-bottom: 1px solid #ccc;
}

.accordion-header {
    padding: 12px 16px;
    cursor: pointer;
    background-color: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 500;
}

.accordion-panel {
    display: none;
    padding: 12px 16px;
    background-color: #fff;
}

.accordion-panel.open {
    display: block;
}

.accordion-header .arrow {
    font-size: 14px;
    transition: transform 0.2s ease;
}

/* Ensure modal backdrop covers header/navbar which may have high z-index */
.modal-backdrop {
    z-index: 99990 !important;
}
.modal {
    z-index: 99999 !important;
}

/* Position the horizontalChartModal dialog with no top margin */
#horizontalChartModal .modal-dialog {
    margin: 0 auto 0 auto !important;
}

/* Remove top margin from modal content */
#horizontalChartModal .modal-content {
    margin-top: 0 !important;
    border: none !important;
}

/* Remove header padding inside horizontal modal and tighten close button */
#horizontalChartModal .modal-header {
    padding: 0 !important;
    align-items: center;
}
#horizontalChartModal .modal-header {
    border-bottom: none !important;
}
#horizontalChartModal .modal-title {
    margin: 0.5rem 1rem;
    font-size: 1.125rem;
}
#horizontalChartModal .modal-header .btn-close {
    margin: 0.25rem 0.5rem;
}

/* Remove bottom border from modal-content h5 specifically inside the horizontal modal */
#horizontalChartModal .modal-content h5 {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

</style>
@endsection

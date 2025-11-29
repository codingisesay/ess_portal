@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<style>
    .search-container {
        position: relative;
        margin-left: 10px;
    }
    .search-box {
        display: flex;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
        width: 40px;
        overflow: hidden;
    }
    .search-box.expanded {
        width: 250px;
    }
    .search-icon {
        position: absolute;
        left: 10px;
        cursor: pointer;
        z-index: 2;
        width: 20px;
        height: 20px;
    }
    .search-input {
        padding-left: 40px;
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }
    .search-box.expanded .search-input {
        opacity: 1;
        visibility: visible;
    }
    .d-flex {
        display: flex !important;
        align-items: center;
        gap: 15px;
        margin-bottom: 1.5rem;
    }
    .toggle-buttons {
        display: flex;
        gap: 10px;
    }
</style>

<div class="container">
    <h3>Organization Settings</h3>
    <div class="d-flex">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showOrgSettingsForm(this)">Show Form</button>
            <button onclick="showOrgSettingsTable(this)">Show Table</button>
        </div>
        
        <!-- Search Box with Icon (initially hidden) -->
        <div class="search-container" id="tableSearchContainer" style="display: none;">
            <div class="search-box">
                <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="searchIcon">
                <input type="text" id="tableSearch" placeholder="Search..." class="search-input">
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="formSection">
       <form action="{{ url('/org-settings') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" 
                            value="{{ old('name', $setting->name ?? '') }}" required
                            placeholder=" "
                            onfocus="this.placeholder = 'Enter organization name'"
                            onblur="this.placeholder = ' '">
                        <label for="name">Organization Name</label>
                    </div>
                </div>

                {{-- Financial Year --}}
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="year" id="year" class="form-control" required>
                            <option value="" disabled selected></option>
                            @php
                                $currentYear = date('Y');
                                for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
                                    $selected = old('year') == $i ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i - ".($i+1)."</option>";
                                }
                            @endphp
                        </select>
                        <label for="year">Financial Year</label>
                    </div>
                </div>

                {{-- Cycle Type --}}
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="cycle_type" id="cycle_type" class="form-control" required
                                onfocus="this.querySelector('option[value=\'\']').textContent='Select Cycle Type'"
                                onblur="if(!this.value) this.querySelector('option[value=\'\']').textContent=''">
                            <option value="" disabled selected></option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="half-yearly">Half Yearly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        <label for="cycle_type">Cycle Type</label>
                    </div>
                </div>

                {{-- Dynamic Cycle Dropdown --}}
                <div class="col-3 mb-3" id="cycleWrapper" style="display:none;">
                    <div class="form-group">
                        <select name="cycle_period" id="cycle_period" class="form-control" required
                                onfocus="this.querySelector('option[value=\'\']').textContent='Select Period'"
                                onblur="if(!this.value) this.querySelector('option[value=\'\']').textContent=''">
                            <option value="" disabled selected></option>
                        </select>
                        <label for="cycle_period">Cycle Period</label>
                    </div>
                </div>

                {{-- Start Date --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                        <label for="start_date">Start Date</label>
                    </div>
                </div>

                {{-- End Date --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                        <label for="end_date">End Date</label>
                    </div>
                </div>

                {{-- Process Start Date --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <input type="date" name="process_start_date" id="process_start_date" class="form-control" required>
                        <label for="process_start_date">Process Start Date</label>
                    </div>
                </div>

                {{-- Process End Date --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <input type="date" name="process_end_date" id="process_end_date" class="form-control" required>
                        <label for="process_end_date">Process End Date</label>
                    </div>
                </div>


                <div class="col-12">
                    <button class="create-btn" type="submit">Save Settings</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
@php
// Format date fields before sending to table partial
$formattedOrgSettings = $orgSettings->map(function ($item) {
    $item->start_date          = \Carbon\Carbon::parse($item->start_date)->format('d/m/Y');
    $item->end_date            = \Carbon\Carbon::parse($item->end_date)->format('d/m/Y');
    $item->process_start_date  = $item->process_start_date 
                                  ? \Carbon\Carbon::parse($item->process_start_date)->format('d/m/Y') 
                                  : null;
    $item->process_end_date    = $item->process_end_date 
                                  ? \Carbon\Carbon::parse($item->process_end_date)->format('d/m/Y') 
                                  : null;
    // Format cycle type to have first letter capitalized
    $item->cycle_type = ucfirst($item->cycle_type);
    // Add formatted status
    $item->status = $item->is_active == 1 ? 'Active' : 'Inactive';
    // Format year as financial year (e.g., 2023-24)
    // Converts a base year (e.g., 2023) to financial year format (e.g., 2023-24)
    // by appending a hyphen and the last two digits of the next year
    $item->financial_year = $item->year . '-' . substr(($item->year + 1), -2);
    return $item;
});
@endphp

    @include('partials.data_table', [
        'items' => $formattedOrgSettings ?? [],
        'columns' => [
            ['header' => 'ID', 'accessor' => 'id'],
            ['header' => 'Name', 'accessor' => 'name'],
            ['header' => 'Year', 'accessor' => 'financial_year'],
            ['header' => 'Cycle Type', 'accessor' => 'cycle_type'],
            ['header' => 'Cycle Period', 'accessor' => 'cycle_period'],
            ['header' => 'Start Date', 'accessor' => 'start_date'],
            ['header' => 'End Date', 'accessor' => 'end_date'],
            ['header' => 'Process Start Date', 'accessor' => 'process_start_date'],
            ['header' => 'Process End Date', 'accessor' => 'process_end_date'],
            ['header' => 'Status', 'accessor' => 'status'],
        ],
        'editModalId' => 'editOrgSettingsModal',
        'hasActions' => true,
        'perPage' => 5
    ])
</div>

    <!-- Edit Modal -->
    <div id="editOrgSettingsModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Organization Setting</h5>
                    <button type="button" class="btn-close btn-close-white" onclick="closeEditModal('editOrgSettingsModal')" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrgSettingsForm" method="POST" onsubmit="handleFormSubmit(event)">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-container row">
                            <div class="col-3 mb-3">
                                <label for="edit_name" class="form-label fw-bold mb-1">Organization Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_year" class="form-label fw-bold mb-1">Financial Year</label>
                                <select name="year" id="edit_year" class="form-select" required>
                                    @php
                                        $currentYear = date('Y');
                                        for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
                                            echo "<option value='$i'>$i - ".($i+1)."</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_cycle_type" class="form-label fw-bold mb-1">Cycle Type</label>
                                <select name="cycle_type" id="edit_cycle_type" class="form-select" required>
                                    <option value="">Select Cycle Type</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="half-yearly">Half Yearly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="col-3 mb-3" id="edit_cycleWrapper" style="display:none;">
                                <label for="edit_cycle_period" class="form-label fw-bold mb-1">Cycle Period</label>
                                <select name="cycle_period" id="edit_cycle_period" class="form-select" required>
                                    <option value="">Select Period</option>
                                </select>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_start_date" class="form-label fw-bold mb-1">Start Date</label>
                                <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_end_date" class="form-label fw-bold mb-1">End Date</label>
                                <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_process_start_date" class="form-label fw-bold mb-1">Process Start Date</label>
                                <input type="date" name="process_start_date" id="edit_process_start_date" class="form-control" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_process_end_date" class="form-label fw-bold mb-1">Process End Date</label>
                                <input type="date" name="process_end_date" id="edit_process_end_date" class="form-control" required>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="edit_status" class="form-label fw-bold mb-1">Status</label>
                                <select name="is_active" id="edit_status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeEditModal('editOrgSettingsModal')">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" id="modalBackdrop" style="display: none;"></div>
</div>


<style>
.modal {
    z-index: 9999 !important;
}
.modal-header {
    background-color: #d49da7 !important;
    color: white !important;
}
.btn-primary {
    background-color: #702851 !important;
    border-color: #702851 !important;
}
.btn-primary:hover {
    background-color: #5f2147 !important;
    border-color: #5f2147 !important;
}
.modal-backdrop {
    z-index: 9998 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
}
</style>

<!-- Toast container for success/error messages -->
<div id="orgSettingsToast" class="org-toast" role="status" aria-live="polite" style="display:none;">
    <div id="orgSettingsToastMessage" class="org-toast-message"></div>
</div>

<style>
/* Simple toast styles */
.org-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    min-width: 220px;
    max-width: 360px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 6px;
    overflow: hidden;
    transition: transform 220ms ease, opacity 220ms ease;
}
.org-toast.show { display: block; opacity: 1; transform: translateY(0); }
.org-toast.hide { opacity: 0; transform: translateY(-10px); }
.org-toast-message { padding: 12px 16px; font-size: 14px; color: #fff; }
.org-toast-message.success { background-color: #198754; }
.org-toast-message.error { background-color: #dc3545; }
</style>

<script>
// Function to open edit modal and populate form
function openEditModal(modalId, data) {
    const modal = document.getElementById(modalId);
    const backdrop = document.getElementById('modalBackdrop');
    const form = document.getElementById('editOrgSettingsForm');
    
    // Set form action with ID
    form.action = `/org-settings/${data.id}`;
    
    // Populate form fields
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_name').value = data.name || '';
    document.getElementById('edit_year').value = data.year || '';
    document.getElementById('edit_cycle_type').value = data.cycle_type?.toLowerCase() || '';
    
    // Trigger cycle type change to load periods
    const cycleTypeEvent = new Event('change');
    document.getElementById('edit_cycle_type').dispatchEvent(cycleTypeEvent);
    
    // Set cycle period after a small delay to ensure options are loaded
    setTimeout(() => {
        document.getElementById('edit_cycle_period').value = data.cycle_period || '';
    }, 100);
    
    // Format dates from d/m/Y to YYYY-MM-DD for date inputs
    const formatDateForInput = (dateStr) => {
        if (!dateStr) return '';
        const [day, month, year] = dateStr.split('/');
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    };
    
    document.getElementById('edit_start_date').value = formatDateForInput(data.start_date);
    document.getElementById('edit_end_date').value = formatDateForInput(data.end_date);
    document.getElementById('edit_process_start_date').value = formatDateForInput(data.process_start_date);
    document.getElementById('edit_process_end_date').value = formatDateForInput(data.process_end_date);
    
    // Set status
    document.getElementById('edit_status').value = data.is_active == 1 ? '1' : '0';
    
    // Show modal and backdrop
    modal.style.display = 'block';
    backdrop.style.display = 'block';
    document.body.classList.add('modal-open');
}

// Close modal with animation
function closeEditModal(modalId) {
    const modal = document.getElementById(modalId);
    const backdrop = document.getElementById('modalBackdrop');
    
    modal.style.animation = 'fadeOut 0.3s';
    backdrop.style.animation = 'fadeOut 0.3s';
    
    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
        modal.style.animation = '';
        backdrop.style.animation = '';
    }, 300);
}

// Minimal AJAX submit handler (no console/alert calls)
async function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');

    // Simple UX feedback
    submitButton.disabled = true;
    submitButton.innerHTML = 'Saving...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            credentials: 'same-origin', // send cookies so Laravel can read the session
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(new FormData(form))
        });

        // parse JSON safely
        const data = await response.json().catch(() => ({}));

        if (response.ok) {
            // Show success toast, close modal and reload after short delay
            showOrgToast('Settings updated successfully!', 'success');
            closeEditModal('editOrgSettingsModal');
            setTimeout(() => window.location.reload(), 900);
        } else {
            // Show error toast (message may be empty)
            const msg = data.message || (data.errors ? Object.values(data.errors).join('\n') : 'Failed to update settings.');
            showOrgToast(msg, 'error');
        }
    } catch (err) {
        // Show generic error toast
        showOrgToast('An unexpected error occurred.', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Save changes';
    }
}

// Toast helper
function showOrgToast(message, type = 'success') {
    const container = document.getElementById('orgSettingsToast');
    const msgEl = document.getElementById('orgSettingsToastMessage');
    if (!container || !msgEl) return;

    msgEl.textContent = message;
    msgEl.classList.remove('success', 'error');
    msgEl.classList.add(type === 'error' ? 'error' : 'success');

    container.classList.remove('hide');
    container.style.display = 'block';
    container.classList.add('show');

    // auto hide after 3s
    setTimeout(() => {
        container.classList.remove('show');
        container.classList.add('hide');
        setTimeout(() => container.style.display = 'none', 250);
    }, 3000);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editOrgSettingsModal');
    if (event.target == modal) {
        closeEditModal('editOrgSettingsModal');
    }
}

document.getElementById("cycle_type").addEventListener("change", function() {
    const type = this.value;
    const cycleWrapper = document.getElementById("cycleWrapper");
    const cycleSelect = document.getElementById("cycle_period");

    cycleSelect.innerHTML = '<option value="" disabled selected></option>';
    cycleSelect.disabled = true; // reset

    if (!type) {
        cycleWrapper.style.display = "none";
        return;
    }

    cycleWrapper.style.display = "block";

    if (type === "monthly") {
        const months = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];
        months.forEach((m,i) => {
            cycleSelect.innerHTML += `<option value="M${i+1}">${m}</option>`;
        });
    }
    else if (type === "quarterly") {
        cycleSelect.innerHTML += `<option value="Q1">Q1 (Apr - Jun)</option>`;
        cycleSelect.innerHTML += `<option value="Q2">Q2 (Jul - Sep)</option>`;
        cycleSelect.innerHTML += `<option value="Q3">Q3 (Oct - Dec)</option>`;
        cycleSelect.innerHTML += `<option value="Q4">Q4 (Jan - Mar)</option>`;
    }
    else if (type === "half-yearly") {
        cycleSelect.innerHTML += `<option value="H1">H1 (Apr - Sep)</option>`;
        cycleSelect.innerHTML += `<option value="H2">H2 (Oct - Mar)</option>`;
    }
    else if (type === "yearly") {
        cycleSelect.innerHTML += `<option value="FY">Full Year</option>`;
    }

    cycleSelect.disabled = false; // enable when options are loaded
});

// Function to calculate dates based on year, cycle type and period
function calculateEditDates() {
    const yearSelect = document.getElementById("edit_year");
    const cycleType = document.getElementById("edit_cycle_type").value;
    const cyclePeriod = document.getElementById("edit_cycle_period").value;
    const startInput = document.getElementById("edit_start_date");
    const endInput = document.getElementById("edit_end_date");
    const processStartInput = document.getElementById("edit_process_start_date");
    const processEndInput = document.getElementById("edit_process_end_date");

    if (!cycleType || !cyclePeriod || !yearSelect.value) {
        startInput.value = "";
        endInput.value = "";
        processStartInput.value = "";
        processEndInput.value = "";
        return;
    }

    let fyStartYear = parseInt(yearSelect.value); // e.g. 2026
    let fyEndYear = fyStartYear + 1;             // e.g. 2027

    let startDate = null;
    let endDate = null;
    let processStartDate = null;
    let processEndDate = null;

    // ========== Monthly ==========
    if (cycleType === "monthly") {
        const monthIndex = parseInt(cyclePeriod.replace("M", "")) - 1; // 0 = Jan ... 11 = Dec
        let actualYear = (monthIndex >= 3) ? fyStartYear : fyEndYear; // Apr-Dec in start year, Jan-Mar in next year
        
        // Set start date to 1st of the month
        startDate = new Date(actualYear, monthIndex, 1);
        
        // Set end date to last day of the month
        endDate = new Date(actualYear, monthIndex + 1, 0);
        
        // Process dates
        processStartDate = new Date(actualYear, monthIndex, 1);
        processEndDate = new Date(actualYear, monthIndex, 15);
    }

    // ========== Quarterly ==========
    else if (cycleType === "quarterly") {
        if (cyclePeriod === "Q1") {
            startDate = new Date(fyStartYear, 3, 1);   // Apr 1
            endDate = new Date(fyStartYear, 5, 30);    // Jun 30
        } else if (cyclePeriod === "Q2") {
            startDate = new Date(fyStartYear, 6, 1);   // Jul 1
            endDate = new Date(fyStartYear, 8, 30);    // Sep 30
        } else if (cyclePeriod === "Q3") {
            startDate = new Date(fyStartYear, 9, 1);   // Oct 1
            endDate = new Date(fyStartYear, 11, 31);   // Dec 31
        } else if (cyclePeriod === "Q4") {
            startDate = new Date(fyEndYear, 0, 1);     // Jan 1
            endDate = new Date(fyEndYear, 2, 31);      // Mar 31
        }
        // Process dates (start of quarter to 15th of first month)
        processStartDate = new Date(startDate);
        processEndDate = new Date(startDate.getFullYear(), startDate.getMonth(), 15);
    }

    // ========== Half-Yearly ==========
    else if (cycleType === "half-yearly") {
        if (cyclePeriod === "H1") {
            startDate = new Date(fyStartYear, 3, 1);   // Apr 1
            endDate = new Date(fyStartYear, 8, 30);    // Sep 30
        } else if (cyclePeriod === "H2") {
            startDate = new Date(fyStartYear, 9, 1);   // Oct 1
            endDate = new Date(fyEndYear, 2, 31);      // Mar 31
        }
        // Process dates (start of half-year to 15th of first month)
        processStartDate = new Date(startDate);
        processEndDate = new Date(startDate.getFullYear(), startDate.getMonth(), 15);
    }

    // ========== Yearly ==========
    else if (cycleType === "yearly") {
        startDate = new Date(fyStartYear, 3, 1);   // Apr 1
        endDate = new Date(fyEndYear, 2, 31);      // Mar 31
        processStartDate = new Date(fyStartYear, 3, 1);  // Apr 1
        processEndDate = new Date(fyStartYear, 3, 15);   // Apr 15
    }

    // Format dates to YYYY-MM-DD for input fields
    function formatDate(date) {
        if (!date) return '';
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    // Fill input fields with properly formatted dates
    if (startDate && endDate) {
        startInput.value = formatDate(startDate);
        endInput.value = formatDate(endDate);
        processStartInput.value = formatDate(processStartDate);
        processEndInput.value = formatDate(processEndDate);
    }
}

// Edit modal cycle type change handler
document.getElementById("edit_cycle_type").addEventListener("change", function() {
    const type = this.value;
    const cycleWrapper = document.getElementById("edit_cycleWrapper");
    const cycleSelect = document.getElementById("edit_cycle_period");

    cycleSelect.innerHTML = '<option value="" disabled selected></option>';
    cycleSelect.disabled = true;

    if (!type) {
        cycleWrapper.style.display = "none";
        return;
    }

    cycleWrapper.style.display = "block";

    if (type === "monthly") {
        const months = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];
        months.forEach((m,i) => {
            cycleSelect.innerHTML += `<option value="M${i+1}">${m}</option>`;
        });
    }
    else if (type === "quarterly") {
        cycleSelect.innerHTML += `<option value="Q1">Q1 (Apr - Jun)</option>`;
        cycleSelect.innerHTML += `<option value="Q2">Q2 (Jul - Sep)</option>`;
        cycleSelect.innerHTML += `<option value="Q3">Q3 (Oct - Dec)</option>`;
        cycleSelect.innerHTML += `<option value="Q4">Q4 (Jan - Mar)</option>`;
    }
    else if (type === "half-yearly") {
        cycleSelect.innerHTML += `<option value="H1">H1 (Apr - Sep)</option>`;
        cycleSelect.innerHTML += `<option value="H2">H2 (Oct - Mar)</option>`;
    }
    else if (type === "yearly") {
        cycleSelect.innerHTML += `<option value="FY">Full Year</option>`;
    }

    cycleSelect.disabled = false;
    
    // Auto-select first option and trigger change
    if (cycleSelect.options.length > 1) {
        cycleSelect.selectedIndex = 1;
        const event = new Event('change');
        cycleSelect.dispatchEvent(event);
    }
});

// Add event listeners for date calculation
document.getElementById("edit_cycle_period").addEventListener("change", calculateEditDates);
document.getElementById("edit_year").addEventListener("change", calculateEditDates);

// Initialize date calculation when cycle type changes
document.getElementById("edit_cycle_type").addEventListener("change", function() {
    // Small delay to ensure the period select is populated
    setTimeout(calculateEditDates, 100);
});


function calculateDates() {
    const yearSelect = document.getElementById("year");
    const cycleType = document.getElementById("cycle_type").value;
    const cyclePeriod = document.getElementById("cycle_period").value;
    const startInput = document.getElementById("start_date");
    const endInput = document.getElementById("end_date");

    if (!cycleType || !cyclePeriod || !yearSelect.value) {
        startInput.value = "";
        endInput.value = "";
        return;
    }

    let fyStartYear = parseInt(yearSelect.value); // e.g. 2026
    let fyEndYear = fyStartYear + 1;             // e.g. 2027

    let startDate = null;
    let endDate = null;

    // ========== Monthly ==========
    if (cycleType === "monthly") {
        const monthIndex = parseInt(cyclePeriod.replace("M", "")) - 1; // 0 = Jan ... 11 = Dec
        let actualYear = (monthIndex >= 3) ? fyStartYear : fyEndYear; // Apr-Dec in start year, Jan-Mar in next year
        
        // Set start date to 1st of the month
        startDate = new Date(actualYear, monthIndex, 1);
        
        // Set end date to last day of the month
        endDate = new Date(actualYear, monthIndex + 1, 0);
    }

    // ========== Quarterly ==========
    else if (cycleType === "quarterly") {
        if (cyclePeriod === "Q1") {
            startDate = new Date(fyStartYear, 3, 1);   // Apr 1
            endDate = new Date(fyStartYear, 5, 30);    // Jun 30
        } else if (cyclePeriod === "Q2") {
            startDate = new Date(fyStartYear, 6, 1);   // Jul 1
            endDate = new Date(fyStartYear, 8, 30);    // Sep 30
        } else if (cyclePeriod === "Q3") {
            startDate = new Date(fyStartYear, 9, 1);   // Oct 1
            endDate = new Date(fyStartYear, 11, 31);   // Dec 31
        } else if (cyclePeriod === "Q4") {
            startDate = new Date(fyEndYear, 0, 1);     // Jan 1
            endDate = new Date(fyEndYear, 2, 31);      // Mar 31
        }
    }

    // ========== Half-Yearly ==========
    else if (cycleType === "half-yearly") {
        if (cyclePeriod === "H1") {
            startDate = new Date(fyStartYear, 3, 1);   // Apr 1
            endDate = new Date(fyStartYear, 8, 30);    // Sep 30
        } else if (cyclePeriod === "H2") {
            startDate = new Date(fyStartYear, 9, 1);   // Oct 1
            endDate = new Date(fyEndYear, 2, 31);      // Mar 31
        }
    }

    // ========== Yearly ==========
    else if (cycleType === "yearly") {
        startDate = new Date(fyStartYear, 3, 1);   // Apr 1
        endDate = new Date(fyEndYear, 2, 31);      // Mar 31
    }

    // Format dates to YYYY-MM-DD for input fields
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    // Fill input fields with properly formatted dates
    if (startDate && endDate) {
        startInput.value = formatDate(startDate);
        endInput.value = formatDate(endDate);
    }
}

// Attach listeners
document.getElementById("year").addEventListener("change", calculateDates);
document.getElementById("cycle_period").addEventListener("change", calculateDates);
</script>


<script>
    // Search box toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const searchIcon = document.getElementById('searchIcon');
        const searchInput = document.getElementById('tableSearch');
        
        if (searchIcon && searchInput) {
            // Toggle search box on icon click
            searchIcon.addEventListener('click', function() {
                searchBox.classList.toggle('expanded');
                if (searchBox.classList.contains('expanded')) {
                    // Focus the input when expanding
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                }
            });
            
            // Close search when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target) && searchBox.classList.contains('expanded')) {
                    searchBox.classList.remove('expanded');
                }
            });
            
            // Prevent search box from closing when clicking inside it
            searchInput.addEventListener('click', function(event) {
                event.stopPropagation();
            });
            
            // Handle search input
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableSection tbody tr');
                
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
        
        // Show form by default on page load
        showOrgSettingsForm(document.querySelector('.toggle-buttons button:first-child'));
    });

    function showOrgSettingsForm(clickedElement) {
        // Show form section and hide table section
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        
        // Hide search container
        document.getElementById('tableSearchContainer').style.display = 'none';
        
        // Collapse search box if it's expanded
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.classList.remove('expanded');
        }
        
        updateActiveButton(clickedElement);
    }

    function showOrgSettingsTable(clickedElement) {
        // Show table section and hide form section
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        
        // Show search container when table is shown
        document.getElementById('tableSearchContainer').style.display = 'block';
        
        updateActiveButton(clickedElement);
    }
    
    function updateActiveButton(clickedElement) {
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }
</script>
@endsection
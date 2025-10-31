@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">

<div class="container">
    <h3>Organization Settings</h3>
    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button onclick="showOrgSettingsTable(this)">Show Table</button>
        <button onclick="showOrgSettingsForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection">
       <form action="{{ url('/org-settings') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-3">
                    <label for="name" class="form-label fw-bold mb-1">Organization Name</label>
                    <input type="text" name="name" id="name" class="form-control" 
                        value="{{ old('name', $setting->name ?? '') }}" required
                        placeholder="Enter organization name">
                </div>

                {{-- Financial Year --}}
                <div class="col-3 mb-3">
                    <label for="year" class="form-label fw-bold mb-1">Financial Year</label>
                    <select name="year" id="year" class="form-select" required>
                        @php
                            $currentYear = date('Y');
                            for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
                                echo "<option value='$i' " . ($i == $currentYear ? "selected" : "") . ">$i - ".($i+1)."</option>";
                            }
                        @endphp
                    </select>
                </div>

                {{-- Cycle Type --}}
                <div class="col-3 mb-3">
                    <label for="cycle_type" class="form-label fw-bold mb-1">Cycle Type</label>
                    <select name="cycle_type" id="cycle_type" class="form-select" required>
                        <option value="">Select Cycle Type</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="half-yearly">Half Yearly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                {{-- Dynamic Cycle Dropdown --}}
                <div class="col-3 mb-3" id="cycleWrapper" style="display:none;">
                    <label for="cycle_period" class="form-label fw-bold mb-1">Cycle Period</label>
                    <select name="cycle_period" id="cycle_period" class="form-select" required>
                        <option value="">Select Period</option>
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-3 mb-3">
                    <label for="start_date" class="form-label fw-bold mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>

                {{-- End Date --}}
                <div class="col-3 mb-3">
                    <label for="end_date" class="form-label fw-bold mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                {{-- Process Start Date --}}
                <div class="col-3 mb-3">
                    <label for="process_start_date" class="form-label fw-bold mb-1">Process Start Date</label>
                    <input type="date" name="process_start_date" id="process_start_date" class="form-control" required>
                </div>

                {{-- Process End Date --}}
                <div class="col-3 mb-3">
                    <label for="process_end_date" class="form-label fw-bold mb-1">Process End Date</label>
                    <input type="date" name="process_end_date" id="process_end_date" class="form-control" required>
                </div>


                <div class="col-12">
                    <button class="create-btn" type="submit">Save Settings</button>
                </div>
            </div>
        </form>
    </div>

       <!-- Table Section issue no--(3743) --> 
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

<div id="tableSection">
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

    <!-- Edit Modal (structure only, fill as needed) -->
    <div id="editOrgSettingsModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal">
                <span onclick="document.getElementById('editOrgSettingsModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Organization Setting</h2>
            </header>
            <div class="w3-container">
                <!-- Edit form goes here -->
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById("cycle_type").addEventListener("change", function() {
    const type = this.value;
    const cycleWrapper = document.getElementById("cycleWrapper");
    const cycleSelect = document.getElementById("cycle_period");

    cycleSelect.innerHTML = '<option value="">Select Period</option>';
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
    function showOrgSettingsForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }

    function showOrgSettingsTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }

    // Show table by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showOrgSettingsTable(firstButton);
    });
</script>
@endsection
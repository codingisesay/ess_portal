@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($results);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
</head>
<body>
    <div class="container">
        <h3>Create Leave Policy</h3>

        <div class="d-flex">
            <!-- Toggle Buttons -->
            <div class="toggle-buttons">
                <button class="active" onclick="showLeavePolicyForm(this)">Show Form</button>
                <button onclick="showLeavePolicyTable(this)">Show Table</button>
            </div>
            
            <!-- Search Box with Icon (initially hidden) -->
            <div class="search-container" id="tableSearchContainer" style="display: none;">
                <div class="search-box">
                    <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="searchIcon">
                    <input
                    type="text"
                    id="tableSearch"
                    class="search-input"
                    placeholder="Search..."
                    data-search-input
                    data-table-section="tableSection"
                    data-no-results="noResults"
                    />
                </div>
            </div>
        </div>
    {{-- @endif --}}
    
    {{-- @if(session('error'))
    <div class="alert custom-alert-error">
        <strong> {{ session('error') }}</strong>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif  --}}

    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li class="text-danger">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif

         <!-- Form Section -->
        <div id="formSection">
            <form action="{{ route('insertPolicyConf') }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="form-container row">
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="leave_type_id" class="form-control" required>
                                <option disabled selected>Select</option>
                                @foreach ($results as $result)
                                    <option value="{{ $result->leave_type_id }}">{{ $result->leave_type }}</option>
                                @endforeach
                            </select>
                            <label for="category_id">
                               Select Leave Type <span style="color:red">*</span>
                            </label>

                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="max_leave_count" class="num-range" required  data-min="1" data-max="YEAR_DAYS" >
                            <label for="category_name">
                               Max Leave <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="max_leave_at_time" class="form-control" required min="1" oninput="validateMaxLeave(this)" step="1">
                            <label for="category_name">
                              Max Leave At Time <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="min_leave_at_time" class="form-control"  min="0.5"  oninput="validateMinLeave(this)" required step="0.5">
                            <label for="category_name">
                              Min Leave At Time <span style="color:red">*</span>
                            </label>
                        </div> 
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="leave_count_per_month" class="num-validate" data-min="0" data-max="31" data-step="0.5" required >
                            <label for="category_name">
                              Leave Count Per Month <span style="color:red">*</span>
                            </label>
                        </div> 
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="no_of_leaves_per_month" required data-min="1" data-max="31" data-step="1" class="num-validate">
                            <label for="category_name">
                              No of Times Per Months <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <select id="is_carry_forward" name="is_carry_forward" class="form-control" required>
                            <option disabled selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option> 
                        </select>
                        <label for="is_carry_forward">
                              Is Carry Forward? <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" id="no_of_carry_forward" name="no_of_carry_forward" class="num-validate"    required data-min="0" data-max="365" data-step="1">
                        <label for="no_of_carry_forward">
                              No. Of Carry Forward <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="LeaveEncash" name="leave_encash" class="form-control" required>
                                <option disabled selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option> 
                            </select>
                            <label for="LeaveEncash">
                              Is Leave Encash? <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="NoOfLeaveEncash" name="leave_encash_count" required class="num-validate" data-min="1" data-max="365" data-step="1">
                            <label for="category_name">
                              No. Of Leave Encash <span style="color:red">*</span>
                            </label>
                        </div> 
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="provision_status" class="form-control" required>
                                <option disabled selected>Select</option>
                                <option value="Applicable">Applicable</option>
                                <option value="Not Applicable">Not Applicable</option> 
                            </select>
                            <label for="category_name">
                              Provision Status <span style="color:red">*</span>
                            </label>
                        </div> 
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="max_leave_pp" class="num-validate" data-min="0" data-max="90" data-step="1">
                            <label for="category_name">
                              Max Leave Probation Period <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="probation_period_per_month" class="num-validate" data-min="1" data-max="6" data-step="1">
                            <label for="category_name">
                              Probation Period Per Month <span style="color:red">*</span>
                            </label>
                        </div> 
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="calendra_start_for_PP" class="num-validate" data-min="1" data-max="12" data-step="1">
                            <label for="category_name">
                              Calendra Start For PP <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Type</button></div> 

                </div>
            </form>
        </div>
 
    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $dataFromLeaveRestctions,
            'columns' => [
                ['header' => 'Id', 'accessor' => 'id'],
                ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                ['header' => 'Max Leave', 'accessor' => 'max_leave'],
                ['header' => 'Max Leave At Time', 'accessor' => 'max_leave_at_time'],
                ['header' => 'Min Leave At Time', 'accessor' => 'min_leave_at_time'],
                ['header' => 'Leave Count Per Month', 'accessor' => 'leave_count_per_month'],
                ['header' => 'No of Times Per Month', 'accessor' => 'no_of_time_per_month'],
                ['header' => 'Carry Forward', 'accessor' => 'carry_forward'],
                ['header' => 'No. of Carry Forward', 'accessor' => 'no_carry_forward'],
                ['header' => 'Encash', 'accessor' => 'leave_encash'],
                ['header' => 'No. of Encash', 'accessor' => 'no_leave_encash'],
                ['header' => 'Provision Status', 'accessor' => 'provision_status'],
                ['header' => 'Max Leave Probation Period', 'accessor' => 'max_leave_PP'],
                ['header' => 'Probation Period Per Month', 'accessor' => 'provision_period_per_month'],
                ['header' => 'Calendra Start For PP', 'accessor' => 'calendra_start_for_PP'], 
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
    @include('partials.no-results')
    </div>

    <div id="editLeavePolicyModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeavePolicyModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Policy</h2>
            </header>
            <div class="w3-container">
                <form id="editLeavePolicyForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="policy_id" id="editLeavePolicyId">
                    <div class="popup-form-group">
                        <input type="text" id="editLeaveType" disabled>
                        <label for="editLeaveType">
                              Leave Type  <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="max_leave_count" id="editMaxLeave" required class="num-range" required  data-min="1" data-max="YEAR_DAYS">
                        <label for="editMaxLeave">
                              Max Leave <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="max_leave_at_time" id="editMaxLeaveAtTime" required required min="1" oninput="validateMaxLeave(this)" step="1">
                        <label for="editMaxLeaveAtTime">
                              Max Leave At Time <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="min_leave_at_time" id="editMinLeaveAtTime" required step="0.5" oninput="validateMinLeave(this)">
                        <label for="editMinLeaveAtTime">
                              Min Leave At Time <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="leave_count_per_month" id="editLeaveCountPerMonth" required class="num-validate" data-min="0" data-max="31" data-step="0.5">
                        <label for="editLeaveCountPerMonth">
                              Leave Count Per Month <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="no_of_leaves_per_month" id="editNoOfTimesPerMonth" required class="num-validate" data-min="1" data-max="31" data-step="1">
                        <label for="editNoOfTimesPerMonth">
                              No of Times Per Month <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <select name="is_carry_forward" id="editCarryForward" required> editCarryForward editNoOfCarryForward
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label for="editCarryForward">
                              No of Times Per Month <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="no_of_carry_forward" id="editNoOfCarryForward" class="num-validate" data-min="0" data-max="365" data-step="1">
                        <label for="editNoOfCarryForward">
                              No. Of Carry Forward <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <select name="leave_encash" id="editLeaveEncash" required> 
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label for="editLeaveEncash">
                              Leave Encash <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="leave_encash_count" id="editNoOfLeaveEncash" class="num-validate" data-min="1" data-max="365" data-step="1">
                        <label for="editNoOfLeaveEncash">
                              No. Of Leave Encash <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <select name="provision_status" id="editProvisionStatus" required>
                            <option value="Applicable">Applicable</option>
                            <option value="Not Applicable">Not Applicable</option>
                        </select>
                        <label for="editProvisionStatus">
                              Provision Status <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="max_leave_pp" id="editMaxLeavePP" required class="num-validate" data-min="0" data-max="90" data-step="1">
                        <label for="editMaxLeavePP">
                              Max Leave Probation Period <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="probation_period_per_month" id="editProbationPeriodPerMonth" required class="num-validate" data-min="0" data-max="6" data-step="1">
                        <label for="editProbationPeriodPerMonth">
                              Probation Period Per Month <span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <input type="number" name="calendra_start_for_PP" id="editCalendraStartForPP" required class="num-validate" data-min="1" data-max="12" data-step="1">
                        <label for="editCalendraStartForPP">
                              Calendra Start For PP<span style="color:red">*</span>
                        </label>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const carryForwardSelect = document.getElementById('is_carry_forward');
    const noOfCarryForwardInput = document.getElementById('no_of_carry_forward');
    
    function toggleCarryForwardInput() {
        if (carryForwardSelect.value === 'No') {
            noOfCarryForwardInput.disabled = true;
            noOfCarryForwardInput.value = '';
        } else {
            noOfCarryForwardInput.disabled = false;
        }
    }
    
    toggleCarryForwardInput();
    carryForwardSelect.addEventListener('change', toggleCarryForwardInput);
});
    </script>

 <script>
        document.addEventListener('DOMContentLoaded', function() {  
    const carryForwardSelect = document.getElementById('LeaveEncash');
    const noOfCarryForwardInput = document.getElementById('NoOfLeaveEncash');
    
    function toggleCarryForwardInput() {
        if (carryForwardSelect.value === 'No') {
            noOfCarryForwardInput.disabled = true;
            noOfCarryForwardInput.value = '';
        } else {
            noOfCarryForwardInput.disabled = false;
        }
    }
    
    toggleCarryForwardInput();
    carryForwardSelect.addEventListener('change', toggleCarryForwardInput);
});
    </script>

 <script>
        document.addEventListener('DOMContentLoaded', function() {  
    const carryForwardSelect = document.getElementById('editCarryForward');
    const noOfCarryForwardInput = document.getElementById('editNoOfCarryForward');
    
    function toggleCarryForwardInput() {
        if (carryForwardSelect.value === 'No') {
            noOfCarryForwardInput.disabled = true;
            noOfCarryForwardInput.value = '';
        } else {
            noOfCarryForwardInput.disabled = false;
        }
    }
    
    toggleCarryForwardInput();
    carryForwardSelect.addEventListener('change', toggleCarryForwardInput);
});
    </script>

     <script>
        document.addEventListener('DOMContentLoaded', function() {   
    const carryForwardSelect = document.getElementById('editLeaveEncash');
    const noOfCarryForwardInput = document.getElementById('editNoOfLeaveEncash');
    
    function toggleCarryForwardInput() {
        if (carryForwardSelect.value === 'No') {
            noOfCarryForwardInput.disabled = true;
            noOfCarryForwardInput.value = '';
        } else {
            noOfCarryForwardInput.disabled = false;
        }
    }
    
    toggleCarryForwardInput();
    carryForwardSelect.addEventListener('change', toggleCarryForwardInput);
});
    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    //  Select by NAME instead of ID
    const provisionSelect = document.querySelector('select[name="provision_status"]');
    const maxLeavePP = document.querySelector('input[name="max_leave_pp"]');
    const probationPerMonth = document.querySelector('input[name="probation_period_per_month"]');
    const calendarPP = document.querySelector('input[name="calendra_start_for_PP"]');

    if (!provisionSelect) return;

    function toggleProvisionFields() {
        if (provisionSelect.value === 'Not Applicable') {

            maxLeavePP.disabled = true;
            probationPerMonth.disabled = true;
            calendarPP.disabled = true;

            maxLeavePP.removeAttribute('required');
            probationPerMonth.removeAttribute('required');
            calendarPP.removeAttribute('required');

            maxLeavePP.value = '';
            probationPerMonth.value = '';
            calendarPP.value = '';

        } else if (provisionSelect.value === 'Applicable') {

            maxLeavePP.disabled = false;
            probationPerMonth.disabled = false;
            calendarPP.disabled = false;

            maxLeavePP.setAttribute('required', 'required');
            probationPerMonth.setAttribute('required', 'required');
            calendarPP.setAttribute('required', 'required');
        }
    }

    // Run on load + change
    toggleProvisionFields();
    provisionSelect.addEventListener('change', toggleProvisionFields);

});
</script>





    <script>
        // Show form by default
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
            
            // Show form by default
            showLeavePolicyForm(document.querySelector('.toggle-buttons button:first-child'));
        });

        function showLeavePolicyForm(clickedElement) {
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

        function showLeavePolicyTable(clickedElement) {
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


        function openEditModal(id, leavedata) {
            document.getElementById('editLeavePolicyId').value = leavedata.id;
            document.getElementById('editLeaveType').value = leavedata.leave_type;
            document.getElementById('editMaxLeave').value = leavedata.max_leave;
            document.getElementById('editMaxLeaveAtTime').value = leavedata.max_leave_at_time;
            document.getElementById('editMinLeaveAtTime').value = leavedata.min_leave_at_time;
            document.getElementById('editLeaveCountPerMonth').value = leavedata.leave_count_per_month;
            document.getElementById('editNoOfTimesPerMonth').value = leavedata.no_of_time_per_month;
            document.getElementById('editCarryForward').value = leavedata.carry_forward;
            document.getElementById('editNoOfCarryForward').value = leavedata.no_carry_forward;
            document.getElementById('editLeaveEncash').value = leavedata.leave_encash;
            document.getElementById('editNoOfLeaveEncash').value = leavedata.no_leave_encash;
            document.getElementById('editProvisionStatus').value = leavedata.provision_status;
            document.getElementById('editMaxLeavePP').value = leavedata.max_leave_PP;
            document.getElementById('editProbationPeriodPerMonth').value = leavedata.provision_period_per_month;
            document.getElementById('editCalendraStartForPP').value = leavedata.calendra_start_for_PP;

            const formAction = "{{ route('update_policy_conf', ['id' => ':id']) }}".replace(':id', leavedata.id);
            document.getElementById('editLeavePolicyForm').action = formAction;

            document.getElementById('editLeavePolicyModal').style.display = 'block';
        }
    </script>

    <script>
function validateMinLeave(input) {
    let value = input.value;

    // Remove non-numeric characters
    value = value.replace(/[^0-9]/g, '');

    // Limit to 3 digits
    if (value.length > 3) {
        value = value.slice(0, 3);
    }

    // Convert to number
    let num = Number(value);

    // Enforce range 1–365
    if (num > 365) num = 365;
    if (num < 1 && value !== '') num = 1;

    input.value = value ? num : '';

    // Cross check with Max Leave
    const maxInput = document.getElementById('max_leave_at_time');
    if (maxInput.value && num > Number(maxInput.value)) {
        input.value = maxInput.value;
    }
}

function validateMaxLeave(input) {
    let value = input.value;

    value = value.replace(/[^0-9]/g, '');

    if (value.length > 3) {
        value = value.slice(0, 3);
    }

    let num = Number(value);

    if (num > 365) num = 365;
    if (num < 1 && value !== '') num = 1;

    input.value = value ? num : '';

    // Cross check with Min Leave
    const minInput = document.getElementById('min_leave_at_time');
    if (minInput.value && num < Number(minInput.value)) {
        input.value = minInput.value;
    }
}
</script>

@endsection


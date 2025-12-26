@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
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
        <h3>Create Leave Type</h3>

        <div class="d-flex">
            <!-- Toggle Buttons -->
            <div class="toggle-buttons">
                <button class="active" onclick="showLeaveTypeForm(this)">Show Form</button>
                <button onclick="showLeaveTypeTable(this)">Show Table</button>
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

        <!-- Form Section -->
        <div id="formSection" class="text-danger">
            @if($errors->any())
            <div class="alert custom-alert-warning">
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="leaveTypeForm" action="{{ route('insert_policy_type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div  class="form-container row">
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="cycle_slot_id" class="form-control" required>
                                <option disabled selected>Select</option>
                                @foreach ($leaveCycleDatas as $leaveCycleData)
                                <option value="{{$leaveCycleData->id}}">{{ $leaveCycleData->name }}</option>
                                @endforeach
                            </select>
                            <label for="category_id">
                                Select Cycle <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="text" id="category_name" name="leave_category" class="only-alpha" required  
                            >
                            <label for="category_name">
                                Leave Type Name <span style="color:red">*</span>
                            </label>

                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="half_day_status" class="form-control" required>
                                <option disabled selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="category_id">
                                Half Day Applicable? <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="status" class="form-control" required>
                                <option disabled selected>Select</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <label for="category_id">
                                Status <span style="color:red">*</span>
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
                'items' => $results,
                'columns' => [  
                    ['header' => 'ID', 'accessor' => 'id'],
                    ['header' => 'Cycle Name', 'accessor' => 'leave_cycle_name'],
                    ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                    ['header' => 'Half Day', 'accessor' => 'leave_half_status'],
                    ['header' => 'Status', 'accessor' => 'leave_status'],
                ],
                'editModalId' => 'openEditModal',
                'hasActions' => true,
                'perPage' => 5,
                'actionCallback' => function($item) {
                    return "openEditModal(" . json_encode($item) . ")";
                }
            ])
        </div>
        @include('partials.no-results')
    

        <div id="editLeaveTypeModal" class="w3-modal" style="display: none;">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-teal"> 
                    <span onclick="document.getElementById('editLeaveTypeModal').style.display='none'" 
                    class="w3-button w3-display-topright">&times;</span>
                    <h2>Edit Leave Type</h2>
                </header>
                <div class="w3-container">
                    <form id="editLeaveTypeForm" method="POST" action="{{ route('update_policy_type') }}">
                        @csrf
                        <input type="hidden" name="leave_type_id" id="editLeaveTypeId"> <!-- Hidden input for leave_type_id -->
                        <div class="popup-form-group">
                            <select name="cycle_slot_id" id="editLeaveCycle" required>
                                @foreach ($leaveCycleDatas as $leaveCycleData)
                                    <option value="{{ $leaveCycleData->id }}">{{ $leaveCycleData->name }}</option>
                                @endforeach
                            </select>
                            <label for="editLeaveCycle">
                                Select Cycle <span style="color:red">*</span>
                            </label>
                        </div>
                        <div class="popup-form-group">
                            <input type="text" name="leave_category" id="editLeaveTypeName" required class="only-alpha"
                            >
                            <label for="editLeaveTypeName">
                               Leave Type Name <span style="color:red">*</span>
                            </label>
                        </div>
                        <div class="popup-form-group">
                            <select name="half_day_status" id="editHalfDayStatus" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                             <label for="editHalfDayStatus">
                               Half Day Applicable? <span style="color:red">*</span>
                            </label>
                        </div>
                        <div class="popup-form-group">
                            <select name="status" id="editLeaveStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <label for="editLeaveStatus">
                               Status <span style="color:red">*</span>
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
                showLeaveTypeForm(document.querySelector('.toggle-buttons button:first-child'));
            });

            function showLeaveTypeForm(clickedElement) {
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

            function showLeaveTypeTable(clickedElement) {
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

            

            function openEditModal(results, levtyps) {
                document.getElementById('editLeaveTypeId').value = levtyps.leave_type_id; // Set the leave_type_id
                document.getElementById('editLeaveCycle').value = levtyps.leave_cycle_id; // Set the cycle ID
                document.getElementById('editLeaveTypeName').value = levtyps.leave_type; // Set the leave type name
                document.getElementById('editHalfDayStatus').value = levtyps.leave_half_status; // Set the half-day status
                document.getElementById('editLeaveStatus').value = levtyps.leave_status; // Set the status

                document.getElementById('editLeaveTypeModal').style.display = 'block'; // Show the modal
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('leaveTypeForm');
            
            if (form) {
                form.addEventListener('submit', function (e) {
                    // 1. Get current values from the form
                    const cycleSelect = document.querySelector('select[name="cycle_slot_id"]');
                    const selectedCycleText = cycleSelect.options[cycleSelect.selectedIndex].text.trim().toLowerCase();
                    const enteredLeaveType = document.getElementById('category_name').value.trim().toLowerCase();

                    // 2. Identify all rows in the data table
                    // Based on your columns: Cycle Name is 2nd column, Leave Type is 3rd column
                    const tableRows = document.querySelectorAll('#tableSection tbody tr');
                    let isDuplicate = false;

                    tableRows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 3) {
                            const existingCycle = cells[1].textContent.trim().toLowerCase();
                            const existingType = cells[2].textContent.trim().toLowerCase();

                            // 3. Check if the combination matches
                            if (existingCycle === selectedCycleText && existingType === enteredLeaveType) {
                                isDuplicate = true;
                            }
                        }
                    });

                    // 4. If duplicate found, stop submission and show SWAL
                    if (isDuplicate) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicate Entry',
                            text: `The Leave Type "${enteredLeaveType.toUpperCase()}" already exists for the cycle "${selectedCycleText.toUpperCase()}".`,
                            confirmButtonColor: '#3085d6'
                        });
                        return false;
                    }
                });
            }
        });
        </script>
@endsection
</body>
</html>

@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($dataFromLeaveRestctions);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
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
        <h3>Employee Type Leave Policy</h3>

        <div class="d-flex">
            <!-- Toggle Buttons -->
            <div class="toggle-buttons">
                <button class="active" onclick="showEmployeePolicyForm(this)">Show Form</button>
                <button onclick="showEmployeePolicyTable(this)">Show Table</button>
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
        <div id="formSection">
            <form action="{{route('insert_emp_restriction')}}" method="POST">
                @csrf
                <div  class="form-container row">
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="restriction_id" class="form-control" required>
                                <option disabled selected>Select</option>
                                @foreach ($dataFromLeaveRestctions as $dataFromLeaveRestction)
                                    <option value="{{ $dataFromLeaveRestction->leave_restriction_id }}">{{ $dataFromLeaveRestction->leave_type }}</option>
                                @endforeach
                            </select>
                            <label for="category_name">
                               Leave Type <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="emp_id" class="form-control" required>
                                <option disabled selected>Select</option>
                                @foreach ($empTypes as $empType)
                                    <option value="{{ $empType->id }}">{{ $empType->name }}</option>
                                @endforeach
                            </select>
                            <label for="category_name">
                              Employee Type <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="leave_count" class="form-control" required min="0" max="365" step="1" required oninput="validateLeaveCount(this)">
                            <label for="category_name">
                              Leave Count <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="date" name="month_start" class="form-control"  min="1" max="31" step="1" required oninput="validateMonthStart(this)">
                            <label>
                              Month Start <span style="color:red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Cycle</button>
                    </div>
                </div>
            </form>
        </div>
 
    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $dataFroms,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                ['header' => 'Employee Type', 'accessor' => 'employee_type'],
                ['header' => 'Leave Count', 'accessor' => 'leave_count'],
                ['header' => 'Month Start', 'accessor' => 'month_start'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => false,
            'perPage' => 5
        ])
    </div>
    @include('partials.no-results')

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
            showEmployeePolicyForm(document.querySelector('.toggle-buttons button:first-child'));
        });

        function showEmployeePolicyForm(clickedElement) {
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

        function showEmployeePolicyTable(clickedElement) {
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

        function validateInput(input) {
            if (input.value > 30) {
                input.value = 30;  // Set the value to 30 if it exceeds the limit
                alert('The value cannot exceed 30.');
            }
        }

       function validateMonthStart(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            let num = Number(value);

            if (num > 31) num = 31;
            if (num < 1 && value !== '') num = 1;

            input.value = value ? num : '';
        }

            function validateLeaveCount(input) {
                let value = input.value.replace(/[^0-9]/g, '');
                let num = Number(value);

                if (num > 365) num = 365;
                if (num < 0) num = 0;

                input.value = value ? num : '';
            }

        
    
    </script>
@endsection
</body>
</html>

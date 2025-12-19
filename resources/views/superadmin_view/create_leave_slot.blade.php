@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($leaveCycleDatas);
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
        <h3>Create Leave Policy Cycle</h3>

        <div class="d-flex">
            <!-- Toggle Buttons -->
            <div class="toggle-buttons">
                <button class="active" onclick="showLeaveSlotForm(this)">Show Form</button>
                <button onclick="showLeaveSlotTable(this)">Show Table</button>
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
            <form action="{{ route('insert_policy_slot') }}" method="POST" >
                @csrf
                <div class="form-container row">
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="cycle_name" class="form-control" required>
                        <label for="category_name">Cycle Name</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" id="category_name" name="start_date_time" class="form-control" required>
                        <label for="category_name">Start Date Time</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" id="category_name" name="end_date_time" class="form-control" required>
                        <label for="category_name">End Date Time</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input id="text" id="category_name" name="year_slot" class="form-control" required>
                        <label for="year">Input Year: (EX: 2025-26)</label>
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
            'items' => $leaveCycleDatas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Cycle Name', 'accessor' => 'name'],
                ['header' => 'Start', 'accessor' => 'start_date'],
                ['header' => 'End', 'accessor' => 'end_date'],
                ['header' => 'Year', 'accessor' => 'year'], 
            ],
            'editModalId' => 'openEditUserModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
    @include('partials.no-results')


    </div>

    <div id="editLeaveSlotModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeaveSlotModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Policy Cycle</h2>
            </header>
            <div class="w3-container">
                <form id="editLeaveSlotForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="cycle_id" id="editLeaveSlotId">
                    <div class="popup-form-group">
                        <input type="text" name="cycle_name" id="editLeaveSlotName" required>
                        <label for="editLeaveSlotName">Cycle Name</label>
                    </div>
                    <div class="popup-form-group">
                        <input type="datetime-local" name="start_date_time" id="editLeaveSlotStartDate" required>
                        <label for="editLeaveSlotStartDate">Start Date Time</label>
                    </div>
                    <div class="popup-form-group">
                        <input type="datetime-local" name="end_date_time" id="editLeaveSlotEndDate" required>
                        <label for="editLeaveSlotEndDate">End Date Time</label>
                    </div>
                    <div class="popup-form-group">
                        <input type="text" name="year_slot" id="editLeaveSlotYear" required>
                        <label for="editLeaveSlotYear">Year</label>
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
            showLeaveSlotForm(document.querySelector('.toggle-buttons button:first-child'));
        });

        function showLeaveSlotForm(clickedElement) {
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

        function showLeaveSlotTable(clickedElement) {
            // Show table section and hide form section
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            
            // Show search container when table is shown
            document.getElementById('tableSearchContainer').style.display = 'block';
            
            updateActiveButton(clickedElement);
        }

        function showLeaveSlotSearch(clickedElement) {
            // Show search container and hide form and table sections
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'none';
            document.getElementById('tableSearchContainer').style.display = 'block';
            
            // Expand search box
            const searchBox = document.querySelector('.search-box');
            if (searchBox) {
                searchBox.classList.add('expanded');
            }
            
            updateActiveButton(clickedElement);
        }
        
        function updateActiveButton(clickedElement) {
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            }
            clickedElement.classList.add('active');
        }

        function openEditModal(id, leavs) {
            if (!id) {
                alert('Invalid leave slot data. Please try again.');
                return;
            }
            document.getElementById('editLeaveSlotId').value = leavs.id;
            document.getElementById('editLeaveSlotName').value = leavs.name || '';
            document.getElementById('editLeaveSlotStartDate').value = leavs.start_date || '';
            document.getElementById('editLeaveSlotEndDate').value = leavs.end_date || '';
            document.getElementById('editLeaveSlotYear').value = leavs.year || '';

            const formAction = "{{ route('update_policy_slot', ['id' => ':id']) }}".replace(':id', leavs.id);
            document.getElementById('editLeaveSlotForm').action = formAction;

            document.getElementById('editLeaveSlotModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

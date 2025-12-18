@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
error_reporting(0);
$id = Auth::guard('superadmin')->user()->id;
// dd($categories);
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
    <title>Create Reimbursement Type</title>
    
</head>
<body>
    <div class="container">
        <h3>Create Reimbursement Type</h3>

        <div class="d-flex">
            <!-- Toggle Buttons -->
            <div class="toggle-buttons">
                <button class="active" onclick="showHRPolicyForm(this)">Show Form</button>
                <button onclick="showHRPolicyTable(this)">Show Table</button>
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
            
        <form action="{{ route('insert_reimbursement_type') }}" method="POST">
                @csrf
                <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="category_name" class="form-control" required>
                        <label for="category_name">Reimbursement Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="category_short_name" class="form-control" required>
                        <label for="category_name">Reimbursement Abbreviation</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                <div class="form-group ">
                    <select id="category_id" name="status" class="form-control" required>
                        <option disabled selected>Select</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="category_id">Status</label>
                </div> 
                </div>

                <div class="col-12"> <button type="submit" class="create-btn"  >Save Category</button></div>
                </div>
            </form>
        </div>

     
    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        <!-- change table and column name for table apperance -->
    @include('partials.data_table', [
            'items' => $reim_type,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Reimbursement Name', 'accessor' => 'name'],
                ['header' => 'Reimbursement Abbreviation', 'accessor' => 'short_name'],
                ['header' => 'Status', 'accessor' => 'status'], 
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
    @include('partials.no-results')
 
    </div>

    <!-- Edit Modal -->
    <div id="editReimbursementModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal">
                <span onclick="document.getElementById('editReimbursementModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Reimbursement Type</h2>
            </header>
            <div class="w3-container">
                <form id="editReimbursementForm" action="{{ route('update_reimbursement_type') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="editReimbursementId">
                    <div class="popup-form-group">
                        <input type="text" name="category_name" id="editReimbursementName" required>
                        <label for="editReimbursementName">Reimbursement Name</label>
                    </div>
                    <div class="popup-form-group">
                        <input type="text" name="category_short_name" id="editReimbursementShortName" required>
                        <label for="editReimbursementShortName">Reimbursement Abbreviation</label>
                    </div>
                    <div class="popup-form-group">
                        <select name="status" id="editReimbursementStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="editReimbursementStatus">Status</label>
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
            
            // Show form by default on page load
            showHRPolicyForm(document.querySelector('.toggle-buttons button:first-child'));
        });

        function showHRPolicyForm(clickedElement) {
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

        function showHRPolicyTable(clickedElement) {
            // Show table section and hide form section
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            
            // Show search container when table is shown
            document.getElementById('tableSearchContainer').style.display = 'block';
            
            updateActiveButton(clickedElement);
            
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        // Ensure the form is visible by default on page load
        
    // Show form by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showHRPolicyForm(firstButton);
    });

    function openEditModal(reim_type, userdata) { 
        document.getElementById('editReimbursementId').value = userdata.id;
        document.getElementById('editReimbursementName').value = userdata.name;
        document.getElementById('editReimbursementShortName').value = userdata.short_name;
        document.getElementById('editReimbursementStatus').value = userdata.status;
        document.getElementById('editReimbursementModal').style.display = 'block';
    }
      
 
    </script>
@endsection
</body>
</html>

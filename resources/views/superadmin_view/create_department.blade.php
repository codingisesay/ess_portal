<!-- [file name: create_department.blade.php] -->
@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/pagination.css') }}">

<div class="container">
    <h3>Create Department For Your Organisation</h3>

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
    </style>

    <div class="d-flex justify-content-start align-items-center mb-4" style="gap: 15px;">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showDepartmentForm(this)">Show Form</button>
            <button onclick="showDepartmentTable(this)">Show Table</button>
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
        <form method="POST" action="{{ route('insert_department') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="hidden" name="organisation_id" value="{{ Auth::guard('superadmin')->user()->id }}">
                        <input type="text" name="department_name" required>
                        <label>Department Name</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="create-btn" type="submit">Create Department</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $departments,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
            ],
            'editModalId' => 'editDepartmentModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editDepartmentModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Department</h2>
        </header>
        <div class="w3-container">
            <form id="editDepartmentForm" action="{{ route('update_department') }}" method="POST">
                @csrf
                <input type="hidden" name="department_id" id="editDepartmentId">
                <div class="popup-form-group">
                    <input type="text" name="department_name" placeholder=" " id="editDepartmentName" required>
                    <label for="editDepartmentName">Department Name</label>
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
        }
    });

    function showDepartmentForm(clickedElement) {
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

    function showDepartmentTable(clickedElement) {
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

    function openEditModal(modalId, item) {
        if (modalId === 'editDepartmentModal') {
            document.getElementById('editDepartmentId').value = item.id;
            document.getElementById('editDepartmentName').value = item.name;
            document.getElementById(modalId).style.display = 'block';
        }
    }

    // Ensure the form is shown by default
    document.addEventListener('DOMContentLoaded', function() {
        showDepartmentForm(document.querySelector('.toggle-buttons button:first-child'));
    });
</script>
@endsection
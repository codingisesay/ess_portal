@extends('superadmin_view/superadmin_layout')
@section('content')

<html>
<head>
<title>Bank Master</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<style>
    /* Sort buttons container */
    .sort-buttons {
        display: flex;
        flex-direction: row;
        margin-left: 8px;
        gap: 2px;
    }
    /* Sort button styling - only show arrows */
    .sort-button {
        background: none;
        border: none;
        padding: 0 2px;
        margin: 0;
        cursor: pointer;
        color: white;
        line-height: 1;
        font-size: 16px;
        transition: all 0.2s;
    }
    /* Hover state for sort buttons */
    .sort-button:hover {
        color: #000;
    }
    /* Active sort button state */
    .sort-button.active {
        color: #007bff;
    }
    .sort-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        color: #666;
        text-decoration: none;
        transition: all 0.2s;
    }
    .sort-icon:hover {
        color: #000;
        transform: scale(1.1);
    }
    th {
        position: relative;
        cursor: pointer;
        white-space: nowrap;
        padding: 12px 8px !important;
    }
    .fa-sort {
        opacity: 0.5;
    }
    .fa-sort-up, .fa-sort-down {
        opacity: 1;
    }
    .sort-container {
        display: flex;
        align-items: center;
    }
    
    /* Search box styles */
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <h3>Bank Master</h3>

    <div class="d-flex justify-content-start align-items-center mb-4" style="gap: 15px;">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button onclick="showForm(this)" class="active">Show Form</button>
            <button onclick="showTable(this)">Show Table</button>
        </div>
        
        <!-- Search Box with Icon (initially hidden) -->
        <div class="search-container" id="tableSearchContainer" style="display: none;">
            <div class="search-box">
                <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="searchIcon">
                <input type="text" id="tableSearch" placeholder="Search..." class="search-input">
            </div>
        </div>
    </div>

    <!-- Bank Form (shown by default) -->
    <div id="formSection">
        <form action="{{ route('store_bank') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-4 mb-2">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Bank Name</label>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="form-group">
                        <select name="status" required>
                            <option disabled selected>Select</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="create-btn" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bank Table (hidden by default) -->
    <div class="table-container" id="tableSection" style="display:none;">
        <table class="table border">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th class="sortable" style="position: relative; white-space: nowrap;">
                        <div style="display: inline-flex; align-items: center;">
                            Bank Name
                            <div class="sort-buttons" style="margin-left: 8px;">
                                <a href="#" onclick="sortTable('name', 'asc'); return false;" class="sort-button {{ $sort === 'name' && $order === 'asc' ? 'active' : '' }}" title="Sort A-Z">
                                    <i class="fa fa-caret-up"></i>
                                </a>
                                <a href="#" onclick="sortTable('name', 'desc'); return false;" class="sort-button {{ $sort === 'name' && $order === 'desc' ? 'active' : '' }}" title="Sort Z-A">
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </div>
                        </div>
                    </th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banks as $bank)
                    <tr>
                        <td>{{ $bank->id }}</td>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->status }}</td>
                        <td>
                            <!-- Edit -->
                            <form action="{{ route('update_bank', $bank->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="text" name="name" value="{{ $bank->name }}" required>
                                <select name="status">
                                    <option value="Active" {{ $bank->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $bank->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('delete_bank', $bank->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this bank?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Search functionality
    function performSearch(searchTerm) {
        const rows = document.querySelectorAll('#tableSection tbody tr');
        const searchTermLower = searchTerm.toLowerCase();
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let rowMatches = false;
            
            // Skip the action column (last cell)
            for (let i = 0; i < cells.length - 1; i++) {
                const cellText = cells[i].textContent.toLowerCase();
                if (cellText.includes(searchTermLower)) {
                    rowMatches = true;
                    break;
                }
            }
            
            row.style.display = rowMatches ? '' : 'none';
        });
    }
    
    // Search box toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const searchIcon = document.getElementById('searchIcon');
        const searchInput = document.getElementById('tableSearch');
        let searchTimeout;
        
        if (searchIcon && searchInput) {
            // Toggle search box on icon click
            searchIcon.addEventListener('click', function() {
                searchBox.classList.toggle('expanded');
                if (searchBox.classList.contains('expanded')) {
                    // Focus the input when expanding
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                } else {
                    // Clear search when collapsing
                    searchInput.value = '';
                    performSearch('');
                }
            });
            
            // Handle search input
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch(this.value);
                }, 300);
            });
            
            // Close search when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target) && searchBox.classList.contains('expanded')) {
                    searchBox.classList.remove('expanded');
                    searchInput.value = '';
                    performSearch('');
                }
            });
            
            // Prevent search box from closing when clicking inside it
            searchInput.addEventListener('click', function(event) {
                event.stopPropagation();
            });
            
            // Handle Escape key to clear search
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    this.value = '';
                    performSearch('');
                    searchBox.classList.remove('expanded');
                }
            });
        }
    });

    function showForm(btn) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        // Hide search container
        document.getElementById('tableSearchContainer').style.display = 'none';
        // Collapse search box if it's expanded
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.classList.remove('expanded');
        }
        
        let siblings = btn.parentElement.children;
        for (let s of siblings) s.classList.remove('active');
        btn.classList.add('active');
        
        // Update URL without page reload
        const url = new URL(window.location.href);
        url.searchParams.set('view', 'form');
        window.history.pushState({}, '', url);
    }
    
    function showTable(btn) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        // Show search container when table is shown
        const searchContainer = document.getElementById('tableSearchContainer');
        searchContainer.style.display = 'block';
        
        // Clear any existing search
        const searchInput = document.getElementById('tableSearch');
        if (searchInput) {
            searchInput.value = '';
            performSearch('');
        }

        let siblings = btn.parentElement.children;
        for (let s of siblings) s.classList.remove('active');
        btn.classList.add('active');
        
        // Update URL without page reload
        const url = new URL(window.location.href);
        url.searchParams.set('view', 'table');
        window.history.pushState({}, '', url);
    }
    
    function sortTable(column, order) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', column);
        url.searchParams.set('order', order);
        // Preserve the view state
        url.searchParams.set('view', 'table');
        window.location.href = url.toString();
    }

    // Show form by default or based on URL parameter
    document.addEventListener('DOMContentLoaded', function() {
        // Check URL for view parameter
        const urlParams = new URLSearchParams(window.location.search);
        const view = urlParams.get('view');
        
        // If there are sort parameters, show the table view
        const sortParam = urlParams.get('sort');
        
        if (view === 'table' || sortParam) {
            showTable(document.querySelector('.toggle-buttons button:last-child'));
        } else {
            showForm(document.querySelector('.toggle-buttons button:first-child'));
        }
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const view = urlParams.get('view');
        
        if (view === 'table' || urlParams.get('sort')) {
            showTable(document.querySelector('.toggle-buttons button:last-child'));
        } else {
            showForm(document.querySelector('.toggle-buttons button:first-child'));
        }
    });
</script>

</body>
</html>
@endsection

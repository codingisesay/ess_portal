@extends('superadmin_view/superadmin_layout')  
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
?>


<html>
<head>
<title>Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">

<div class="container">
    <h3>Create Designation For Your Organisation</h3>

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
            <button class="active" onclick="showDesignationForm(this)">Show Form</button>
            <button onclick="showDesignationTable(this)">Show Table</button>
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
    <div id="formSection" >
        <form method="POST" action="{{ route('insert_designation') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="hidden" name="organisation_id" value="{{$id}}">
                        <select name="department_id" required>
                            <option value="" disabled selected></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <label>Department</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="branch_id" required>
                            <option value="" disabled selected></option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <label>Location Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">                    
                    <div class="form-group">
                        <input type="text" name="name" placeholder=" " required>
                        <label>Designation Name</label>
                    </div>
                </div>
               
                <div class="col-12">
                    <button class="create-btn" type="submit">Create Designation</button>
                </div>
            </div>
        </form>
    </div>
 
    <div id="tableSection"  >
        @include('partials.data_table', [
            'items' => $results,
            'columns' => [
                ['header' => 'Designation', 'accessor' => 'department_name'],
                ['header' => 'Branch', 'accessor' => 'branch_name'],
                ['header' => 'Designation', 'accessor' => 'designation_name'], 
            ],
            'editModalId' => 'openEditModal',
            'hasPermision' => true,
            'perPage' => 5
        ])
    </div>
  
</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popup">
    <div class="popup-content" style="z-index:auto">
        <div class="popup-header">
            <h4 class="fw-bold">Create Permission</h4>
            <button class="popup-close" onclick="closePopup()">&times;</button>
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

    function showDesignationForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        // Hide search container
        document.getElementById('tableSearchContainer').style.display = 'none';
        // Collapse search box if it's expanded
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.classList.remove('expanded');
        }
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showDesignationTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        // Show search container when table is shown
        document.getElementById('tableSearchContainer').style.display = 'block';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }
 
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showDesignationForm(firstButton);
    });
 
 
    function openEditModal() { 
        document.getElementById('popup').style.display = 'block';
    }
</script>

@endsection




@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <h3>Creates Salary Templates</h3>

    <div class="d-flex">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showSalaryTemplateForm(this)">Show Form</button>
            <button onclick="showSalaryTemplateTable(this)">Show Table</button>
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
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_salary_template') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="template_name" required>
                        <label>Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="min_ctc" >
                        <label>Min CTC</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="max_ctc" >
                        <label>Max CTC</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="status" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
              
                <div class="col-12">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $template_datas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Template Name', 'accessor' => 'name'],
                ['header' => 'Min CTC', 'accessor' => 'min_ctc'],
                ['header' => 'Max CTC', 'accessor' => 'max_ctc'],
                ['header' => 'Status', 'accessor' => 'status'],
            ], 
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>


</div>

<div id="editSalaryTemplateModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryTemplateModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Salary Template</h2>
        </header>
        <div class="w3-container">
            <form id="editSalaryTemplateForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="template_id" id="editSalaryTemplateId">
                <div class="popup-form-group">
                    <input type="text" name="template_name" id="editSalaryTemplateName" required>
                    <label for="editSalaryTemplateName">Name</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="min_ctc" id="editSalaryTemplateMinCTC">
                    <label for="editSalaryTemplateMinCTC">Min CTC</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="max_ctc" id="editSalaryTemplateMaxCTC">
                    <label for="editSalaryTemplateMaxCTC">Max CTC</label>
                </div>
                <div class="popup-form-group">
                    <select name="status" id="editSalaryTemplateStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editSalaryTemplateStatus">Status</label>
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
        showSalaryTemplateForm(document.querySelector('.toggle-buttons button:first-child'));
    });

    function showSalaryTemplateForm(clickedElement) {
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

    function showSalaryTemplateTable(clickedElement) {
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
    

    function openEditModal(id, templatedata) {
        if (!id) {
            alert('Invalid template data. Please try again.');
            return;
        } 
        document.getElementById('editSalaryTemplateId').value = templatedata.id;
        document.getElementById('editSalaryTemplateName').value = templatedata.name || '';
        document.getElementById('editSalaryTemplateMinCTC').value =templatedata.min_ctc || '';
        document.getElementById('editSalaryTemplateMaxCTC').value = templatedata.max_ctc || '';
        document.getElementById('editSalaryTemplateStatus').value = templatedata.status || '';

        const formAction = "{{ route('update_salary_template', ['id' => ':id']) }}".replace(':id', templatedata.id);
        document.getElementById('editSalaryTemplateForm').action = formAction;

        document.getElementById('editSalaryTemplateModal').style.display = 'block';
    }
</script>

@endsection


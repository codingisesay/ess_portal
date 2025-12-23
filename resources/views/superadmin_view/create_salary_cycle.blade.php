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
    <h3>Creates Salary Cycle</h3>

    <div class="d-flex">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showSalaryCycleForm(this)">Show Form</button>
            <button onclick="showSalaryCycleTable(this)">Show Table</button>
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
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_salary_cycle') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" name="applicable_from" id="applicableFrom" required oninput="validateSalaryDates()">
                        <label>Applicable From</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" name="applicable_to" id="applicableTo" required oninput="validateSalaryDates()">
                        <label>Applicable To</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="month_start_date" required >
                        <label>Month Start Date</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="month_end_date" required>
                        <label>Month End Date</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
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
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $cycle_datas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Start Date', 'accessor' => 'start_date'],
                ['header' => 'End Date', 'accessor' => 'end_date'],
                ['header' => 'Month Start', 'accessor' => 'month_start'],
                ['header' => 'Month End', 'accessor' => 'month_end'],
                ['header' => 'Status', 'accessor' => 'status'],
            ], 
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div> 
    @include('partials.no-results')


</div>

<div id="editSalaryCycleModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryCycleModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Salary Template</h2>
        </header>
        <div class="w3-container">
        <form id="editSalaryCycleForm" method="POST" action="{{ route('update_salary_cycle', ['id' => ':id']) }}">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="editSalaryCycleId">
                <div class="popup-form-group">
                    <input type="text" name="template_name" id="editSalaryCycleName" required>
                    <label for="editSalaryCycleName">Name</label>
                </div>
                <div class="popup-form-group">
                    <input type="datetime-local" name="applicable_from" id="editApplicableFrom" required oninput="validateEditSalaryDates()">
                    <label for="editApplicableFrom">Applicable From</label>
                </div>
                <div class="popup-form-group">
                    <input type="datetime-local" name="applicable_to" id="editApplicableTo" required oninput="validateEditSalaryDates()">
                    <label for="editApplicableTo">Applicable To</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="month_start_date" id="editMonthStartDate" required>
                    <label for="editMonthStartDate">Month Start Date</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="month_end_date" id="editMonthEndDate" required>
                    <label for="editMonthEndDate">Month End Date</label>
                </div>
                <div class="popup-form-group">
                    <select name="status" id="editSalaryCycleStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editSalaryCycleStatus">Status</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showSalaryCycleForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        
        document.getElementById('tableSearchContainer').style.display = 'none';
        
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.classList.remove('expanded');
        }
        
        updateActiveButton(clickedElement);
    }

    function showSalaryCycleTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        
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
 
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const searchIcon = document.getElementById('searchIcon');
        const searchInput = document.getElementById('tableSearch');
        
        if (searchIcon && searchInput) {
            searchIcon.addEventListener('click', function() {
                searchBox.classList.toggle('expanded');
                if (searchBox.classList.contains('expanded')) {
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                }
            });
            
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target) && searchBox.classList.contains('expanded')) {
                    searchBox.classList.remove('expanded');
                }
            });
            
            searchInput.addEventListener('click', function(event) {
                event.stopPropagation();
            });
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableSection tbody tr');
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let rowMatches = false;
                    
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
        
        showSalaryCycleForm(document.querySelector('.toggle-buttons button:first-child'));
    });    

    function openEditModal(id, cycleData) {
    if (!id || !cycleData) {
        alert('Invalid data. Please try again.');
        return;
    }

    // Populate the modal fields
    document.getElementById('editSalaryCycleId').value = cycleData.id;
    document.getElementById('editSalaryCycleName').value = cycleData.name || '';
    document.getElementById('editApplicableFrom').value = cycleData.start_date || '';
    document.getElementById('editApplicableTo').value = cycleData.end_date || '';
    document.getElementById('editMonthStartDate').value = cycleData.month_start || '';
    document.getElementById('editMonthEndDate').value = cycleData.month_end || '';
    document.getElementById('editSalaryCycleStatus').value = cycleData.status || '';

    // Set the form action dynamically
    const formAction = "{{ route('update_salary_cycle', ['id' => ':id']) }}".replace(':id', cycleData.id);
    document.getElementById('editSalaryCycleForm').action = formAction;

    // Show the modal
    document.getElementById('editSalaryCycleModal').style.display = 'block';
}
</script>
<script>
function validateEditSalaryDates() {
    const fromInput = document.getElementById('editApplicableFrom');
    const toInput   = document.getElementById('editApplicableTo');

    if (!fromInput.value || !toInput.value) return;

    const now  = new Date();
    const from = new Date(fromInput.value);
    const to   = new Date(toInput.value);

    if (from < now) {
        fromInput.setCustomValidity('Applicable From cannot be before today');
        return;
    } else {
        fromInput.setCustomValidity('');
    }

    if (to <= from) {
        toInput.setCustomValidity('Applicable To must be after Applicable From');
        return;
    } else {
        toInput.setCustomValidity('');
    }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const now = new Date();
    now.setSeconds(0, 0); // clean seconds

    const minDateTime = now.toISOString().slice(0, 16);

    const from = document.getElementById('applicableFrom');
    const to   = document.getElementById('applicableTo');

    // Disable back dates in calendar
    if (from) from.min = minDateTime;
    if (to)   to.min   = minDateTime;
});

function validateSalaryDates() {
    const fromInput = document.getElementById('applicableFrom');
    const toInput   = document.getElementById('applicableTo');

    if (!fromInput.value || !toInput.value) return;

    const now  = new Date();
    const from = new Date(fromInput.value);
    const to   = new Date(toInput.value);

    //  Applicable From cannot be in the past
    if (from < now) {
        fromInput.setCustomValidity('Applicable From cannot be before today');
        return;
    } else {
        fromInput.setCustomValidity('');
    }

    //  Applicable To must be after Applicable From
    if (to <= from) {
        toInput.setCustomValidity('Applicable To must be after Applicable From');
        return;
    } else {
        toInput.setCustomValidity('');
    }
}
</script>


@endsection


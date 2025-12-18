@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

<!DOCTYPE html>
<html>
<head>
 
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
    <h3>Create Salary Taxes</h3>

    <div class="d-flex">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showUserForm(this)">Show Form</button>
            <button onclick="showUserTable(this)">Show Table</button>
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
    <form method="POST" action="{{ route('insert_taxes') }}">
        @csrf
        <div class="form-container row">
            <div class="col-3 mb-4">
                <div class="form-group">
                    <select name="tax_cycle_type" required>
                        <option disabled selected>Select</option>
                        @foreach ($taxregim as $tax)
                        <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Tax Regime</label>
                </div>
            </div>
            <div class="col-3 mb-4">
                <div class="form-group">
                    <select name="tax_type" required>
                        <option disabled selected>Select</option>
                        <option value="Income Tax">Income Tax</option>
                    </select>
                    <label>Tax Type</label>
                </div>
            </div>
            <div class="col-3 mb-4">
                <div class="form-group">
                    <input type="number" name="min_income" required>
                    <label>Min Income</label>
                </div>
            </div>
            <div class="col-3 mb-4">
                <div class="form-group">
                    <input type="number" name="max_income" required>
                    <label>Max Income</label>
                </div>
            </div>
            <div class="col-3 mb-4">
                <div class="form-group">
                    <input type="number" name="tax_per" required>
                    <label>percentage Tax</label>
                </div>
            </div>
            <div class="col-3 mb-4">
                <div class="form-group">
                    <input type="number" name="fixed_amount" required>
                    <label>Fixed Amount</label>
                </div>
            </div>
            <!-- {{-- <div class="form-group">
                <select name="status" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                   
                </select>
                <label>Status</label>
            </div> --}} -->
            <div class="col-12">
            <button class="create-btn" type="submit">Create</button></div>
        </div>

      
        
    </form>
            </div>
 
            <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        @include('partials.data_table', [
            'items' => $datafortaxes,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Tax Regime', 'accessor' => 'org_tax_regime_years_name'],
                ['header' => 'Tax Type', 'accessor' => 'tax_type'],
                ['header' => 'Min Income', 'accessor' => 'min_income'],
                ['header' => 'Max Income', 'accessor' => 'max_income'],
                ['header' => 'Tax Percentage', 'accessor' => 'tax_per'],
                ['header' => 'Fixed Amount', 'accessor' => 'fixed_amount'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
    @include('partials.no-results')
</div>

<div id="editTaxSlabModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editTaxSlabModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Tax Slab</h2>
        </header>
        <div class="w3-container">
            <form id="editTaxSlabForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="tax_slab_id" id="editTaxSlabId">
                <div class="popup-form-group">
                    <select name="tax_cycle_type" id="editTaxCycle" required>
                        @foreach ($taxregim as $tax)
                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                    <label for="editTaxCycle">Tax Regime</label>
                </div>
                <div class="popup-form-group">
                    <select name="tax_type" id="editTaxType" required>
                        <option value="Income Tax">Income Tax</option>
                    </select>
                    <label for="editTaxType">Tax Type</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="min_income" id="editMinIncome" required>
                    <label for="editMinIncome">Min Income</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="max_income" id="editMaxIncome" required>
                    <label for="editMaxIncome">Max Income</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="tax_per" id="editTaxPercentage" required>
                    <label for="editTaxPercentage">Percentage Tax</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="fixed_amount" id="editFixedAmount" required>
                    <label for="editFixedAmount">Fixed Amount</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, datas) {
        if (!id) {
            alert('Invalid Tax Slab data. Please try again.');
            return;
        }
        
        document.getElementById('editTaxSlabId').value = datas.id;
        // document.getElementById('editTaxCycle').value = datas.org_tax_regime_years_name ;
        
        // Find the tax regime by name and set the select value
        const taxRegimeName = datas.org_tax_regime_years_name; 
        const taxCycleSelect = document.getElementById('editTaxCycle');
        
        // Loop through options to find a match
        for (let i = 0; i < taxCycleSelect.options.length; i++) {
            if (taxCycleSelect.options[i].text === taxRegimeName) {
                taxCycleSelect.value = taxCycleSelect.options[i].value;
                break;
            }
        }
        document.getElementById('editTaxType').value = datas.tax_type || '';
        document.getElementById('editMinIncome').value = datas.min_income || '';
        document.getElementById('editMaxIncome').value = datas.max_income || '';
        document.getElementById('editTaxPercentage').value = datas.tax_per || '';
        document.getElementById('editFixedAmount').value = datas.fixed_amount || '';

        const formAction = "{{ route('update_tax_slab', ['id' => ':id']) }}".replace(':id', datas.id);
        document.getElementById('editTaxSlabForm').action = formAction;

        document.getElementById('editTaxSlabModal').style.display = 'block';
    }
</script>

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
        showUserForm(document.querySelector('.toggle-buttons button:first-child'));
    });

    function showUserForm(clickedElement) {
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

    function showUserTable(clickedElement) {
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

// Show form by default on page load
document.addEventListener('DOMContentLoaded', () => {
    const firstButton = document.querySelector('.toggle-buttons button:first-child');
    showUserForm(firstButton);
});
  
</script>

@endsection


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
    <h3>Pay Heads Master</h3>

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

        <form method="POST" action="{{ route('insert_Components') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Components Name</label>
                    </div>
                </div>
             <!-- component type -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="component_type" required>
                            <option value="" disabled selected></option>
                            <option value="Bonus">Bonus</option>
                            <option value="Earnings for Employees">Earnings for Employees</option>
                            <option value="Deduction from Employees">Deduction from Employees</option>
                            <option value="Loans & Advances">Loans & Advances</option>
                        </select>   
                        <label>Type</label>
                    </div>
                </div>
                <!-- income type -->
                  <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="income_type" required>
                            <option value="" disabled selected></option>
                            <option value="Fixed">Fixed</option>
                            <option value="Variable">Variable</option>
                        </select>
                        <label>Income Type</label>
                    </div>
                </div>
               <!-- affect net salary -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="affect_net_salary" required>
                            <option value="" disabled selected></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label>Affect net salary</label>
                    </div>
                </div>
                <!-- calculate of gratuity -->
                 <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculate_of_gratuity" required>
                            <option value="" disabled selected></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label>Calculate of Gratuity</label>
                    </div>
                </div>
               <!-- calculation type -->
                 <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculation_type" required>
                            <option value="" disabled selected></option>
                            <option value="Flat Rate">Flat Rate</option>
                            <option value="On Attendance">On Attendance</option>
                        </select>
                        <label>Calculation Type</label>
                    </div>
                </div>
               <!-- calculation period -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculation_period" id="calculationPeriodSelect" required>
                            <option value="" disabled selected></option>
                            <option value="User Defined">User Defined</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                        <label>Calculation Period</label>
                        <!-- Hidden input to store the custom days value -->
                        <input type="hidden" name="user_define_days" id="calculationPeriodDays" value="">
                        <!-- Display saved custom days below the select -->
                        <div id="customDaysDisplay" style="margin-top: 8px; font-size: 13px; color: #666; display: none;">
                            <strong>Custom Days:</strong> <span id="customDaysValue">—</span>
                        </div>
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
                ['header' => 'Type', 'accessor' => 'type'],
                ['header' => 'Income Type', 'accessor' => 'income_type'],
                ['header' => 'Affect Net Salary', 'accessor' => 'affect_net_salary'],
                ['header' => 'Calculate of Gratuity', 'accessor' => 'calculate_of_gratuity'],
                ['header' => 'Calculation Type', 'accessor' => 'calculation_type'],
                ['header' => 'Calculation Period', 'accessor' => 'calculation_period'],
                ['header' => 'User Define Days', 'accessor' => 'user_define_days'],
                ['header' => 'Status', 'accessor' => 'status'],
            ], 
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
</div>

<!-- Modal for Custom Days Input -->
<div id="customDaysModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width: 400px;">
        <header class="w3-container w3-teal"> 
            <span onclick="closeCustomDaysModal()" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Define Custom Calculation Period</h2>
        </header>
        <div class="w3-container" style="padding: 20px;">
            <div class="popup-form-group">
                <input type="number" id="customDaysInput" min="1" max="31" placeholder="Enter days (1-31)" required>
                <label for="customDaysInput">How many days?</label>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="create-btn" onclick="saveCustomDays()" style="flex: 1;">Save</button>
                <button type="button" class="create-btn" style="background-color: #6c757d; flex: 1;" onclick="closeCustomDaysModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="editSalaryComponentForm" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryComponentForm').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Salary Template</h2>
        </header>
        <div class="w3-container">
            <form id="editSalaryComponentForm2" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="template_id" id="editSalaryTemplateId">
                <div class="popup-form-group">
                    <input type="text" name="name" id="editSalaryTemplateName" required>
                    <label for="editSalaryTemplateName">Name</label>
                </div>
                <!-- Component Type -->
                <div class="popup-form-group">
                    <select name="type" id="editComponentType" required>
                        <option value="Bonus">Bonus</option>
                        <option value="Earnings for Employees">Earnings for Employees</option>
                        <option value="Deduction from Employees">Deduction from Employees</option>
                        <option value="Loans & Advances">Loans & Advances</option>
                    </select>
                    <label for="editComponentType">Type</label>
                </div>

               <!-- Income Type -->
                <div class="popup-form-group">
                    <select name="income_type" id="editIncomeType" required>
                        <option value="Fixed">Fixed</option>
                        <option value="Variable">Variable</option>
                    </select>
                    <label for="editIncomeType">Income Type</label>
                </div>

                 <!-- Affect Net Salary -->
                <div class="popup-form-group">
                    <select name="affect_net_salary" id="editAffectNetSalary" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editAffectNetSalary">Affect Net Salary</label>
                </div>

                <!-- Calculate Of Gratuity -->
                <div class="popup-form-group">
                    <select name="calculate_of_gratuity" id="editCalculateOfGratuity" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editCalculateOfGratuity">Calculate Of Gratuity</label>
                </div>

                 <!-- Calculation Type -->
                <div class="popup-form-group">
                    <select name="calculation_type" id="editCalculationType" required>
                        <option value="Flat Rate">Flat Rate</option>
                        <option value="On Attendance">On Attendance</option>
                    </select>
                    <label for="editCalculationType">Calculation Type</label>
                </div>

                 <!-- Calculation Period -->
                <div class="popup-form-group">
                    <select name="calculation_period" id="editCalculationPeriod" required>
                        <option value="User Defined">User Defined</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                    <label for="editCalculationPeriod">Calculation Period</label>
                </div>

                <!-- User Defined Days (Visible only when User Defined is selected) -->
                <div class="popup-form-group" id="editUserDaysContainer" style="display:none;">
                    <input type="number" min="1" name="user_define_days" id="editUserDefineDays" placeholder="Enter Days">
                    <label for="editUserDefineDays">User Defined Days</label>
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
    /* ----------------------- CUSTOM DAYS MODAL ----------------------- */

function openCustomDaysModal() {
    document.getElementById('customDaysModal').style.display = 'block';
    document.getElementById('customDaysInput').focus();
}

function closeCustomDaysModal() {
    document.getElementById('customDaysModal').style.display = 'none';
    document.getElementById('customDaysInput').value = '';
}

function saveCustomDays() {
    const daysInput = document.getElementById('customDaysInput');
    const days = daysInput.value.trim();

    if (!days || isNaN(days) || days < 1 || days > 31) {
        alert("Please enter a valid number between 1 and 31");
        daysInput.focus();
        return;
    }

    document.getElementById('calculationPeriodDays').value = days;
    document.getElementById('customDaysDisplay').style.display = 'block';
    document.getElementById('customDaysValue').textContent = days;

    closeCustomDaysModal();
}

/* ----------------------- INITIALIZATION ----------------------- */

document.addEventListener('DOMContentLoaded', function () {

    /* Handle Calculation Period change */
    const calculationPeriodSelect = document.getElementById('calculationPeriodSelect');

    if (calculationPeriodSelect) {
        calculationPeriodSelect.addEventListener('change', function () {
            if (this.value === 'User Defined') {
                openCustomDaysModal();
            } else {
                document.getElementById('customDaysDisplay').style.display = 'none';
                document.getElementById('calculationPeriodDays').value = '';
            }
        });
    }

    /* Close custom modal when clicking outside */
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('customDaysModal');
        if (event.target === modal) {
            closeCustomDaysModal();
        }
    });
});
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

    function showSalaryTemplateSearch(clickedElement) {
        // Show search container and hide form and table sections
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'none';
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
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Helper to safely access element
    function $id(id) {
        const el = document.getElementById(id);
        if (!el) console.warn("Missing element:", id);
        return el;
    }

    const calcPeriod = $id("editCalculationPeriod");
    const userDaysContainer = $id("editUserDaysContainer");
    const userDaysInput = $id("editUserDefineDays");

    // On-change (inside modal)
    if (calcPeriod) {
        calcPeriod.addEventListener("change", function () {
            if (this.value === "User Defined") {
                if (userDaysContainer) userDaysContainer.style.display = "block";
            } else {
                if (userDaysContainer) userDaysContainer.style.display = "none";
                if (userDaysInput) userDaysInput.value = "";
            }
        });
    }

    // -------------------------
    // OPEN EDIT MODAL FUNCTION
    // -------------------------
    window.openEditModal = function (id, templatedata) {

        if (!templatedata) {
            alert("Invalid data passed");
            return;
        }

        // Field references
        const idField = $id("editSalaryTemplateId");
        const nameField = $id("editSalaryTemplateName");
        const compType = $id("editComponentType");
        const incomeType = $id("editIncomeType");
        const affectNet = $id("editAffectNetSalary");
        const gratuity = $id("editCalculateOfGratuity");
        const calcType = $id("editCalculationType");
        const calcPeriodF = $id("editCalculationPeriod");
        const statusField = $id("editSalaryTemplateStatus");
        const formEl = $id("editSalaryComponentForm2");
        const modalEl = $id("editSalaryComponentForm");

        // Fill values
        if (idField) idField.value = templatedata.id || "";
        if (nameField) nameField.value = templatedata.name || "";

        if (compType) compType.value = templatedata.component_type || templatedata.type || "";
        if (incomeType) incomeType.value = templatedata.income_type || "";
        if (affectNet) affectNet.value = templatedata.affect_net_salary || "";
        if (gratuity) gratuity.value = templatedata.calculate_of_gratuity || "";
        if (calcType) calcType.value = templatedata.calculation_type || "";
        if (calcPeriodF) calcPeriodF.value = templatedata.calculation_period || "";
        if (statusField) statusField.value = templatedata.status || "";

        // Handle User Defined days
        if (templatedata.calculation_period === "User Defined") {
            if (userDaysContainer) userDaysContainer.style.display = "block";
            if (userDaysInput) userDaysInput.value = templatedata.user_define_days || "";
        } else {
            if (userDaysContainer) userDaysContainer.style.display = "none";
            if (userDaysInput) userDaysInput.value = "";
        }

        // Set action URL
        try {
            const actionUrl = "{{ route('update_component', ['id' => ':id']) }}".replace(":id", templatedata.id);
            if (formEl) formEl.action = actionUrl;
        } catch (e) {
            console.warn("Form action route not replaced:", e);
        }

        // Show modal
        if (modalEl) modalEl.style.display = "block";
    };
});
</script>



@endsection


@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  <!-- SweetAlert2 for alerts -->

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

        <form method="POST" action="{{ route('insert_Components') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" class="text-only" required >
                        <label>
                            Pay Head Name <span style="color:red">*</span>
                        </label>
                    </div>
                </div>

                 <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="name_to_display_in_payslip" class="text-only" required >
                        <label>
                            Name to Display in Payslip <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
             <!-- component type (added new dropdown for component type) -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="component_type" required>
                            <option disabled selected>Select</option>
                            <option value="Bonus">Bonus</option>
                            <option value="Earnings for Employees">Earnings for Employees</option>
                            <option value="Deduction from Employees">Deduction from Employees</option>
                            <option value="Employees statutory deductions">Employees statutory deductions</option>
                            <option value="Loans & Advances">Loans & Advances</option>
                            <option value="Employers other charges">Employers other charges</option>
                            <option value="Employers statutory contributions ">Employers statutory contributions </option>
                            <option value="Gratuity">Gratuity</option>
                            <option value="Reimbursement to employees">Reimbursement to employees</option>
                            <option value="Tax paid by employers on perquisites">Tax paid by employers on perquisites</option>
                            <option value="Other">Other</option>
                        </select>   
                        <label>
                          Type <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
                <!-- income type -->
                  <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="income_type" required>
                            <option disabled selected>Select</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Variable">Variable</option>
                        </select>
                        <label>
                            Income Type <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
               <!-- affect net salary -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="affect_net_salary" required>
                            <option disabled selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label>
                            Affect Net Salary <span style="color:red">*</span>
                        </label>
                    </div>
                </div>
                <!-- calculate of gratuity -->
                 <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculate_of_gratuity" required>
                            <option disabled selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label>
                            Calculate of Gratuity <span style="color:red">*</span>
                        </label>
                    </div>
                </div>

                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="Set/Alter_Income_Tax_Details" id="incomeTaxDetailsSelect" required>
                            <option disabled selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label>
                            Set/Alter Income Tax Details <span style="color:red">*</span>
                        </label>
                        <!-- Hidden inputs for income tax configuration -->
                        <input type="hidden" name="income_tax_components" id="hiddenIncomeTaxComponents" value="">
                        <input type="hidden" name="tax_calculation_basis" id="hiddenTaxCalculationBasis" value="">
                        <input type="hidden" name="deduct_tds_across_periods" id="hiddenDeductTDSAcrossPeriods" value="">
                    </div>
                </div>
               <!-- calculation type -->
                 <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculation_type" required>
                            <option disabled selected>Select</option>
                            <option value="Computed">Computed</option>
                            <option value="User Defined">User Defined</option>
                            <option value="Flat Rate">Flat Rate</option>
                            <option value="On Attendance">On Attendance</option>
                            <option value="On Attendance">Production</option>
                        </select>
                        <label>
                            Calculation Type <span style="color:red">*</span>
                        </label>

                            <!-- Hidden input for attendance/leave with pay config -->
                            <input type="hidden" name="attendance_leave_with_pay" id="hiddenAttendanceLeaveWithPay" value="">
                    </div>
                </div>
               <!-- calculation period -->
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculation_period" id="calculationPeriodSelect" required>
                            <option disabled selected>Select</option>
                            <option value="Days">Days</option>
                            <option value="Weeks">Weeks</option>
                            <option value="Fortnights">Fortnights</option>
                            <option value="User Defined">User Defined</option>
                            <option value="Monthly">Monthly(As per Calender period)</option>
                        </select>
                        <label>
                            Calculation Period <span style="color:red">*</span>
                        </label>

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
                            <option  disabled selected>Select</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>
                            Status <span style="color:red">*</span>
                        </label>
                        

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

                // Basic Information
                ['header' => 'Pay Head Name', 'accessor' => 'name'],
                ['header' => 'Name to Display in Payslip', 'accessor' => 'name_to_display_in_payslip'],
                ['header' => 'Type', 'accessor' => 'type'],
                ['header' => 'Income Type', 'accessor' => 'income_type'],
                ['header' => 'Affect Net Salary', 'accessor' => 'affect_net_salary'],
                ['header' => 'Calculate of Gratuity', 'accessor' => 'calculate_of_gratuity'],
                ['header' => 'Set/Alter Income Tax Details', 'accessor' => 'set_alter_income_tax_details'],
                ['header' => 'Income Tax Components', 'accessor' => 'income_tax_components'],
                ['header' => 'Tax Calculation Basis', 'accessor' => 'tax_calculation_basis'],
                ['header' => 'Deduct TDS Across Periods', 'accessor' => 'deduct_tds_across_periods'],
                ['header' => 'Attendance / Leave with Pay', 'accessor' => 'attendance_leave_with_pay'],
                ['header' => 'Calculation Type', 'accessor' => 'calculation_type'],
                ['header' => 'Calculation Period', 'accessor' => 'calculation_period'],
                ['header' => 'User Define Days', 'accessor' => 'user_define_days'],

                // Status
                ['header' => 'Status', 'accessor' => 'status'],
            ], 
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])

    </div>
    @include('partials.no-results')
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
                <input type="number" id="customDaysInput" placeholder="Enter days (1-31)"  class="days-only" required >
                <label for="customDaysInput">
                    How many days <span style="color:red">*</span>
                </label>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="create-btn" onclick="saveCustomDays()" style="flex: 1;">Save</button>
                <button type="button" class="create-btn" style="background-color: #6c757d; flex: 1;" onclick="closeCustomDaysModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Income Tax Configuration -->
<div id="incomeTaxModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width: 500px;">
        <header class="w3-container w3-teal"> 
            <span onclick="closeIncomeTaxModal()" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Income Tax Configuration</h2>
        </header>
        <div class="w3-container" >
            <div class="popup-form-group-small">
                <input type="text" id="incomeTaxComponents" placeholder="Income Tax Components" required class="text-only" data-maxlen="100">
                <label for="incomeTaxComponents">
                    Income Tax Components <span style="color:red">*</span>
                </label>
            </div>

            <div class="popup-form-group-small">
                <select id="taxCalculationBasis" required>
                    <option disabled selected>Select</option>
                    <option value="Projected Value">Projected Value</option>
                    <option value="Actual Value">Actual Value</option>
                </select>
                <label for="taxCalculationBasis">
                    Tax Calculation Basis <span style="color:red">*</span>
                </label>
            </div>
            <div class="popup-form-group-small">
                <select id="deductTDSAcrossPeriods" required>
                    <option disabled selected>Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <label for="deductTDSAcrossPeriods">
                    Deduct TDS Across Periods <span style="color:red">*</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="create-btn" onclick="saveIncomeTaxConfig()" style="flex: 1;">Save</button>
                <button type="button" class="create-btn" style="background-color: #6c757d; flex: 1;" onclick="closeIncomeTaxModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Attendance/Leave With Pay Modal -->
<div id="attendanceLeaveModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width: 400px;">
        <header class="w3-container w3-teal"> 
            <span onclick="closeAttendanceLeaveModal()" class="w3-button w3-display-topright">&times;</span>
            <h2>Attendance/Leave With Pay</h2>
        </header>
        <div class="w3-container" style="padding: 20px;">
            <div class="popup-form-group">
                <select id="attendanceLeaveSelect" required>
                    <option disabled selected>Select</option>
                    <option value="Present">Present</option>
                    <option value="LOP">LOP</option>
                    <option value="Leave With Pay">Leave With Pay</option>
                    <option value="Leave Without Pay">Leave Without Pay</option>
                </select>
                <label for="attendanceLeaveSelect">
                    Attendance/Leave Type <span style="color:red">*</span>
                </label>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="create-btn" onclick="saveAttendanceLeaveConfig()" style="flex: 1;">Save</button>
                <button type="button" class="create-btn" style="background-color: #6c757d; flex: 1;" onclick="closeAttendanceLeaveModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="editSalaryComponentForm" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryComponentForm').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Pay Heads Master</h2>
        </header>
        <div class="w3-container">
            <form id="editSalaryComponentForm2" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="template_id" id="editSalaryTemplateId">
                <div class="popup-form-group">
                    <input type="text" name="name" id="editSalaryTemplateName" class="text-only" data-maxlen="100" required >
                    <label for="editSalaryTemplateName">
                        Name <span style="color:red">*</span>
                    </label>
                </div>

                <div class="popup-form-group">
                    <input type="text" name="name_to_display_in_payslip" id="editNameToDisplay"  class="text-only" data-maxlen="100" required >
                    <label for="editNameToDisplay">
                        Name to Display in Payslip <span style="color:red">*</span>
                    </label>
                </div>
                <!-- Component Type -->
                <div class="popup-form-group">
                    <select name="type" id="editComponentType" required>
                        <option disabled selected>Select</option>
                        <option value="Bonus">Bonus</option>
                        <option value="Earnings for Employees">Earnings for Employees</option>
                        <option value="Deduction from Employees">Deduction from Employees</option>
                        <option value="Employees statutory deductions">Employees statutory deductions</option>
                        <option value="Loans & Advances">Loans & Advances</option>
                        <option value="Employers other charges">Employers other charges</option>
                        <option value="Employers statutory contributions">Employers statutory contributions</option>
                        <option value="Gratuity">Gratuity</option>
                        <option value="Reimbursement to employees">Reimbursement to employees</option>
                        <option value="Tax paid by employers on perquisites">Tax paid by employers on perquisites</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="editComponentType">
                        Type <span style="color:red">*</span>
                    </label>
                </div>

               <!-- Income Type -->
                <div class="popup-form-group">
                    <select name="income_type" id="editIncomeType" required>
                        <option value="Fixed">Fixed</option>
                        <option value="Variable">Variable</option>
                    </select>
                    <label for="editIncomeType">
                        Income Type <span style="color:red">*</span>
                    </label>

                </div>

                 <!-- Affect Net Salary -->
                <div class="popup-form-group">
                    <select name="affect_net_salary" id="editAffectNetSalary" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editAffectNetSalary">
                        Affect Net Salary <span style="color:red">*</span>
                    </label>
                </div>

                <!-- Calculate Of Gratuity -->
                <div class="popup-form-group">
                    <select name="calculate_of_gratuity" id="editCalculateOfGratuity" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editCalculateOfGratuity">
                       Calculate Of Gratuity<span style="color:red">*</span>
                    </label>
                </div>

                <!-- Set/Alter Income Tax Details -->
                <div class="popup-form-group">
                    <select name="Set/Alter_Income_Tax_Details" id="editIncomeTaxDetails" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editIncomeTaxDetails">
                       Set/Alter Income Tax Details <span style="color:red">*</span>
                    </label>
                </div>

                    <!-- Income Tax Components -->
                 <div class="popup-form-group">
                    <input type="text" name="income_tax_components" id="editIncomeTaxComponents" placeholder="Income Tax Components" required  class="text-only" data-maxlen="100">
                    <label for="editIncomeTaxComponents">
                       Income Tax Components <span style="color:red">*</span>
                    </label>
                 </div>
                    <!-- Tax Calculation Basis -->
                <div class="popup-form-group">
                    <select name="tax_calculation_basis" id="editTaxCalculationBasis" required>
                        <option value="" disabled selected></option>
                        <option value="Projected Value">Projected Value</option>
                        <option value="Actual Value">Actual Value</option>
                    </select>
                    <label for="editTaxCalculationBasis">
                       Tax Calculation Basis <span style="color:red">*</span>
                    </label>
                </div>
                    <!-- Deduct TDS Across Periods -->
                <div class="popup-form-group">
                    <select name="deduct_tds_across_periods" id="editDeductTDSAcrossPeriods" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="editDeductTDSAcrossPeriods">
                       Deduct TDS Across Periods <span style="color:red">*</span>
                    </label>
                </div>

                 <!-- Calculation Type -->
                <div class="popup-form-group">
                    <select name="calculation_type" id="editCalculationType" required>
                         <option value="Computed">Computed</option>
                         <option value="User Defined">User Defined</option>
                        <option value="Flat Rate">Flat Rate</option>
                        <option value="On Attendance">On Attendance</option>
                        <option value="Production">Production</option>
                    </select>
                    <label for="editCalculationType">
                       Calculation Type <span style="color:red">*</span>
                    </label>
                </div>
                <!-- Attendance/Leave Type (Hidden by default) -->
                <div class="popup-form-group" id="attendanceLeaveWrapper" style="display: none;">
                    <select name="attendance_leave_with_pay" id="editAttendanceLeaveWithPay">
                        <option value="" disabled selected></option>
                        <option value="Present">Present</option>
                        <option value="LOP">LOP</option>
                        <option value="Leave With Pay">Leave With Pay</option>
                        <option value="Leave Without Pay">Leave Without Pay</option>
                    </select>
                    <label for="editAttendanceLeaveWithPay">
                       Attendance/Leave Type <span style="color:red">*</span>
                    </label>
                </div>

                 <!-- Calculation Period -->
                <div class="popup-form-group">
                    <select name="calculation_period" id="editCalculationPeriod" required>
                        <option value="User Defined">User Defined</option>
                        <option value="Monthly">Monthly (As per Calender period)</option>
                    </select>
                    <label for="editCalculationPeriod">
                       Calculation Period <span style="color:red">*</span>
                    </label>
                </div>

                <!-- User Defined Days (Visible only when User Defined is selected) -->
                <div class="popup-form-group" id="editUserDaysContainer" style="display:none;">
                    <input type="number" name="user_define_days" id="editUserDefineDays" placeholder="Enter Days" type="number" data-max="365" class="user-days" required>
                    <label for="editUserDefineDays">
                       User Defined Days <span style="color:red">*</span>
                    </label>
                </div>

                <div class="popup-form-group">
                    <select name="status" id="editSalaryTemplateStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editSalaryTemplateStatus">
                       Status <span style="color:red">*</span>
                    </label>
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
        Swal.fire("Please enter a valid number between 1 and 31");
        daysInput.focus();
        return;
    }

    document.getElementById('calculationPeriodDays').value = days;
    document.getElementById('customDaysDisplay').style.display = 'block';
    document.getElementById('customDaysValue').textContent = days;

    closeCustomDaysModal();
}

/* ----------------------- INCOME TAX MODAL ----------------------- */

function openIncomeTaxModal() {
    document.getElementById('incomeTaxModal').style.display = 'block';
    document.getElementById('incomeTaxComponents').focus();
}

function closeIncomeTaxModal() {
    document.getElementById('incomeTaxModal').style.display = 'none';
    // Reset fields
    document.getElementById('incomeTaxComponents').value = '';
    document.getElementById('taxCalculationBasis').value = '';
    document.getElementById('deductTDSAcrossPeriods').value = '';
}

function saveIncomeTaxConfig() {
    const components = document.getElementById('incomeTaxComponents').value.trim();
    const basis = document.getElementById('taxCalculationBasis').value;
    const tds = document.getElementById('deductTDSAcrossPeriods').value;

    if (!components) {
        Swal.fire("Please enter Income Tax Components");
        return;
    }
    if (!basis) {
        Swal.fire("Please select Tax Calculation Basis");
        return;
    }
    if (!tds) {
        Swal.fire("Please select Deduct TDS Across Periods");
        return;
    }

    // Store the values in hidden inputs
    document.getElementById('hiddenIncomeTaxComponents').value = components;
    document.getElementById('hiddenTaxCalculationBasis').value = basis;
    document.getElementById('hiddenDeductTDSAcrossPeriods').value = tds;

    // Show confirmation
    Swal.fire("Income Tax Configuration saved successfully!");
    closeIncomeTaxModal();
}

/* ----------------------- ATTENDANCE/LEAVE MODAL ----------------------- */

function openAttendanceLeaveModal() {
    document.getElementById('attendanceLeaveModal').style.display = 'block';
    document.getElementById('attendanceLeaveSelect').focus();
}

function closeAttendanceLeaveModal() {
    document.getElementById('attendanceLeaveModal').style.display = 'none';
    document.getElementById('attendanceLeaveSelect').value = '';
}

function saveAttendanceLeaveConfig() {
    const attendanceType = document.getElementById('attendanceLeaveSelect').value;
    if (!attendanceType) {
        Swal.fire('Please select Attendance/Leave Type');
        return;
    }
    document.getElementById('hiddenAttendanceLeaveWithPay').value = attendanceType;
    Swal.fire('Attendance/Leave With Pay configuration saved!');
    closeAttendanceLeaveModal();
}



/* ----------------------- TEXT ONLY VALIDATION ----------------------- */
// function validateTextOnly(input, maxLen = 50) {
//     let val = input.value.replace(/[^a-zA-Z\s.&]/g, '');
//     if (val.length > maxLen) val = val.slice(0, maxLen);
//     input.value = val;
// }

// /* ----------------------- USER DEFINED DAYS VALIDATION ----------------------- */
// function validateUserDefinedDays(input) {
//     // Remove decimals and non-numeric characters
//     input.value = input.value.replace(/[^0-9]/g, '');

//     // Prevent more than 3 digits
//     if (input.value.length > 3) {
//         input.value = input.value.slice(0, 3);
//     }

//     const value = parseInt(input.value, 10);

//     // Enforce range 1 – 365
//     if (value > 365) {
//         input.value = 365;
//     } else if (value < 1 && input.value !== '') {
//         input.value = 1;
//     }
// }


// function validateDays(input) {
//     input.value = input.value.replace(/\D/g, '');
//     if (input.value > 31) input.value = 31;
//     if (input.value < 1) input.value = 1;
// }

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

    /* Handle Income Tax Details change */
    const incomeTaxDetailsSelect = document.getElementById('incomeTaxDetailsSelect');

    if (incomeTaxDetailsSelect) {
        incomeTaxDetailsSelect.addEventListener('change', function () {
            if (this.value === 'Yes') {
                openIncomeTaxModal();
            }
        });
    }

    /* Handle Calculation Type change */
    const calculationTypeSelect = document.querySelector('select[name="calculation_type"]');

    if (calculationTypeSelect) {
        calculationTypeSelect.addEventListener('change', function () {
            if (this.value === 'On Attendance') {
                openAttendanceLeaveModal();
            }
        });
    }

    /* Close custom modal when clicking outside */
    window.addEventListener('click', function (event) {
        const customModal = document.getElementById('customDaysModal');
        const taxModal = document.getElementById('incomeTaxModal');
        const attendanceModal = document.getElementById('attendanceLeaveModal');
        if (event.target === customModal) {
            closeCustomDaysModal();
        }
        if (event.target === taxModal) {
            closeIncomeTaxModal();
        }
        if (event.target === attendanceModal) {
            closeAttendanceLeaveModal();
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

    /* ----------------------------------------------------
       USER DEFINED DAYS LOGIC
    ---------------------------------------------------- */
    const calcPeriod = $id("editCalculationPeriod");
    const userDaysContainer = $id("editUserDaysContainer");
    const userDaysInput = $id("editUserDefineDays");

    if (calcPeriod) {
        calcPeriod.addEventListener("change", function () {
            if (this.value === "User Defined") {
                userDaysContainer.style.display = "block";
            } else {
                userDaysContainer.style.display = "none";
                userDaysInput.value = "";
            }
        });
    }

    /* ----------------------------------------------------
       INCOME TAX TOGGLE LOGIC (Show/Hide + Clear + Backend Support)
    ---------------------------------------------------- */
    const incomeTaxSelect = $id("editIncomeTaxDetails");

    const componentsInput = $id("editIncomeTaxComponents");
    const basisSelect = $id("editTaxCalculationBasis");
    const tdsSelect = $id("editDeductTDSAcrossPeriods");

    const componentsField = componentsInput?.closest(".popup-form-group");
    const basisField = basisSelect?.closest(".popup-form-group");
    const tdsField = tdsSelect?.closest(".popup-form-group");

    function toggleIncomeTaxFields() {
        const isYes = incomeTaxSelect.value === "Yes";

        if (componentsField) componentsField.style.display = isYes ? "block" : "none";
        if (basisField) basisField.style.display = isYes ? "block" : "none";
        if (tdsField) tdsField.style.display = isYes ? "block" : "none";

        componentsInput.required = isYes;
        basisSelect.required = isYes;
        tdsSelect.required = isYes;

        if (!isYes) {
            componentsInput.value = "";
            basisSelect.value = "";
            tdsSelect.value = "";
        }
    }

    // Follow backend value on page load
    toggleIncomeTaxFields();

    incomeTaxSelect.addEventListener("change", toggleIncomeTaxFields);

            /* ----------------------------------------------------
        ON ATTENDANCE LOGIC (Show/Hide + Clear + Backend Support)
        - Define in outer scope so openEditModal can call it
        ---------------------------------------------------- */
        const calcType = $id("editCalculationType");
        const attendanceWrapper = $id("attendanceLeaveWrapper");
        const attendanceSelect = $id("editAttendanceLeaveWithPay");

        // Defensive: if element not found, bail gracefully
        function toggleAttendanceField() {
            if (!calcType || !attendanceWrapper || !attendanceSelect) return;

            // Normalize value from backend/user
            const selected = (calcType.value || "").toString().trim();

            // Compare case-insensitively and tolerate small differences
            if (selected.toLowerCase() === "on attendance".toLowerCase()) {
                attendanceWrapper.style.display = "block";
                // Make select required if you want when visible (optional)
                // attendanceSelect.required = true;
            } else {
                attendanceWrapper.style.display = "none";
                attendanceSelect.value = "";       // clear the value on hide
                // attendanceSelect.required = false;
            }
        }

        // Run on load in case page has default filled by server
        toggleAttendanceField();

        // Ensure user interaction still works
        if (calcType) {
            calcType.addEventListener("change", toggleAttendanceField);
        }



    /* ----------------------------------------------------
       OPEN EDIT MODAL FUNCTION
    ---------------------------------------------------- */
    window.openEditModal = function (id, templatedata) {

        if (!templatedata) {
            Swal.fire("Invalid data passed");
            return;
        }

        // Field references
        const idField = $id("editSalaryTemplateId");
        const nameField = $id("editSalaryTemplateName");
        const nameToDisplay = $id("editNameToDisplay");
        const compType = $id("editComponentType");
        const incomeType = $id("editIncomeType");
        const affectNet = $id("editAffectNetSalary");
        const gratuity = $id("editCalculateOfGratuity");
        const incomeTaxDetails = $id("editIncomeTaxDetails");
        const incomeTaxComp = $id("editIncomeTaxComponents");
        const taxCalcBasis = $id("editTaxCalculationBasis");
        const deductTds = $id("editDeductTDSAcrossPeriods");
        const calcType = $id("editCalculationType");
        const attendancePay = $id("editAttendanceLeaveWithPay");
        const calcPeriodF = $id("editCalculationPeriod");
        const statusField = $id("editSalaryTemplateStatus");
        const formEl = $id("editSalaryComponentForm2");
        const modalEl = $id("editSalaryComponentForm");

        // Fill values from backend
        idField.value = templatedata.id || "";
        nameField.value = templatedata.name || "";
        nameToDisplay.value = templatedata.name_to_display_in_payslip || "";
        compType.value = templatedata.component_type || templatedata.type || "";
        incomeType.value = templatedata.income_type || "";
        affectNet.value = templatedata.affect_net_salary || "";
        gratuity.value = templatedata.calculate_of_gratuity || "";
        calcType.value = templatedata.calculation_type || "";
        attendancePay.value = templatedata.attendance_leave_with_pay || "";
        calcPeriodF.value = templatedata.calculation_period || "";
        statusField.value = templatedata.status || "";

        // Income Tax fields from backend
        incomeTaxDetails.value = templatedata.set_alter_income_tax_details || templatedata.income_tax_details || "";
        incomeTaxComp.value = templatedata.income_tax_components || "";
        taxCalcBasis.value = templatedata.tax_calculation_basis || "";
        deductTds.value = templatedata.deduct_tds_across_periods || "";

        // Apply toggle again for backend value
        toggleIncomeTaxFields();

        // CALL THE TOGGLE HERE to react to backend value
        toggleAttendanceField();

        // User defined days
        if (templatedata.calculation_period === "User Defined") {
            userDaysContainer.style.display = "block";
            userDaysInput.value = templatedata.user_define_days || "";
        } else {
            userDaysContainer.style.display = "none";
            userDaysInput.value = "";
        }

        // Update form action
        try {
            const actionUrl = "{{ route('update_component', ['id' => ':id']) }}"
                .replace(":id", templatedata.id);
            formEl.action = actionUrl;
        } catch (e) {
            console.warn("Form URL error:", e);
        }

        // Open modal
        modalEl.style.display = "block";
    };
});
</script>




@endsection


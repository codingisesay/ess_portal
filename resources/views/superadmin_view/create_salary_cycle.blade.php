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
<div class="container">
    <h3>Creates Salary Cycle</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showSalaryCycleTable(this)">Show Table</button>
        <button onclick="showSalaryCycleForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" >
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
                        <input type="datetime-local" name="applicable_from" required>
                        <label>Applicable From</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" name="applicable_to" required>
                        <label>Applicable To</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="month_start_date" required>
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
     <div id="tableSection">
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
                    <input type="datetime-local" name="applicable_from" id="editApplicableFrom" required>
                    <label for="editApplicableFrom">Applicable From</label>
                </div>
                <div class="popup-form-group">
                    <input type="datetime-local" name="applicable_to" id="editApplicableTo" required>
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
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
    }

    function showSalaryCycleTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
    }
 
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showSalaryCycleTable(firstButton);
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

@endsection


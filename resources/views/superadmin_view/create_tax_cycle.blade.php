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
    <h3>Creates Salary Tax Slot</h3>
 <!-- Toggle Buttons -->
 <div class="toggle-buttons">
 <button onclick="showTaxTable(this)">Show Table</button>
        <button onclick="showTaxForm(this)">Show Form</button>
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
    <div id="formSection" >
    <form method="POST" action="{{ route('insert_tax_cycle') }}">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <input type="text" name="template_name" required>
                <label>Name</label>
            </div>
            <div class="form-group">
                <input type="datetime-local" name="from">
                <label>From</label>
            </div>
            <div class="form-group">
                <input type="datetime-local" name="to" required>
                <label>To</label>
            </div>
            <div class="form-group">
                <select name="status" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                   
                </select>
                <label>Status</label>
            </div>
      
            <div class="col-12">
         <button class="create-btn" type="submit">Create</button> </div>
        </div>

       
    </form>
    </div>
 
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $orgTaxRegim,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Tax Name', 'accessor' => 'name'],
                ['header' => 'Applicable From', 'accessor' => 'applicable_from'],
                ['header' => 'Applicable To', 'accessor' => 'applicable_to'],
                ['header' => 'Status', 'accessor' => 'status'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
 
</div>

<div id="editTaxCycleModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editTaxCycleModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Tax Cycle</h2>
        </header>
        <div class="w3-container">
            <form id="editTaxCycleForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="tax_cycle_id" id="editTaxCycleId">
                <div class="popup-form-group">
                    <label for="editTaxCycleName">Name</label>
                    <input type="text" name="template_name" id="editTaxCycleName" required>
                </div>
                <div class="popup-form-group">
                    <label for="editTaxCycleFrom">From</label>
                    <input type="datetime-local" name="from" id="editTaxCycleFrom" required>
                </div>
                <div class="popup-form-group">
                    <label for="editTaxCycleTo">To</label>
                    <input type="datetime-local" name="to" id="editTaxCycleTo" required>
                </div>
                <div class="popup-form-group">
                    <label for="editTaxCycleStatus">Status</label>
                    <select name="status" id="editTaxCycleStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showTaxForm(clickedElement) {
        // Show form section and hide table section
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none'; 
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showTaxTable(clickedElement) {
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
    showTaxTable(firstButton);
});
  
</script>

<script>
    function openEditModal(id, datas) {
        document.getElementById('editTaxCycleId').value = datas.id;
        document.getElementById('editTaxCycleName').value = datas.name;
        document.getElementById('editTaxCycleFrom').value = datas.applicable_from;
        document.getElementById('editTaxCycleTo').value = datas.applicable_to;
        document.getElementById('editTaxCycleStatus').value = datas.status;

        const formAction = "{{ route('update_tax_cycle', ['id' => ':id']) }}".replace(':id', datas.id);
        document.getElementById('editTaxCycleForm').action = formAction;

        document.getElementById('editTaxCycleModal').style.display = 'block';
    }
</script>

@endsection


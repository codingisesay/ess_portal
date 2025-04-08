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
    <h2>Creates Salary Tax Slot</h2>

    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif

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
        </div>

        <div class="form-container">
            <div class="form-group">
                <button class="create-btn" type="submit">Create</button>
            </div>
        </div>
    </form>

    <h3>Templates Name</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
             
                 
             @foreach ($orgTaxRegim as $orgTax)
                 
            
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $orgTax->name }}</td>
                        <td>{{ $orgTax->applicable_from }}</td>
                        <td>{{ $orgTax->applicable_to }}</td>
                        <td>{{ $orgTax->status }}</td>
                        <td>
                            <button class="edit-icon" onclick="openEditTaxCycleModal({{ $orgTax->id }}, '{{ $orgTax->name }}', '{{ $orgTax->applicable_from }}', '{{ $orgTax->applicable_to }}', '{{ $orgTax->status }}')">Edit</button>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
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
    function openEditTaxCycleModal(id, name, from, to, status) {
        document.getElementById('editTaxCycleId').value = id;
        document.getElementById('editTaxCycleName').value = name;
        document.getElementById('editTaxCycleFrom').value = from;
        document.getElementById('editTaxCycleTo').value = to;
        document.getElementById('editTaxCycleStatus').value = status;

        const formAction = "{{ route('update_tax_cycle', ['id' => ':id']) }}".replace(':id', id);
        document.getElementById('editTaxCycleForm').action = formAction;

        document.getElementById('editTaxCycleModal').style.display = 'block';
    }
</script>

@endsection


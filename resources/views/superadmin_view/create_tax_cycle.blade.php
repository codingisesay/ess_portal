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
      
         <button class="create-btn" type="submit">Create</button> 
        </div>

       
    </form>
    </div>

    
    <!-- Table Section -->
    <div id="tableSection" > 
    
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
                        <td><button class="edit-icon" onclick="openEditBranchModal()">Edit</button></td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>


<script>
function showUserForm(clickedElement) {
    // Show form section and hide table section
    document.getElementById('formSection').style.display = 'block';
    document.getElementById('tableSection').style.display = 'none'; 
    const siblings = clickedElement.parentElement.children;
    for (let sibling of siblings) {
        sibling.classList.remove('active');
    } 
    clickedElement.classList.add('active');
}

    function showUserTable(clickedElement) {
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
    showUserTable(firstButton);
});
  
</script>


@endsection


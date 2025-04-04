@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($templates);
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
    <h2>Creates Salary Templates</h2>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button class="but" onclick="showSalaryComponentForm()">Show Form</button>
        <button class="but" onclick="showSalaryComponentTable()">Show Table</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" style="display: none;">
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_salary_Components') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <select name="template_id" required>
                        <option value="" disabled selected></option>
                        @foreach ($templates as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <label>Salary Template</label>
                </div>
                <div class="form-group">
                    <input type="component_name" name="component_name" required>
                    <label>Component Name</label>
                </div>
                <div class="form-group">
                    <select name="component_type" required>
                        <option value="" disabled selected></option>
                        <option value="Earning">Earning</option>
                        <option value="Deduction">Deduction</option>
                    </select>
                    <label>Type</label>
                </div>
                <div class="form-group">
                    <select name="calculation_type" required>
                        <option value="" disabled selected></option>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </select>
                    <label>Calculation Type</label>
                </div>
                <div class="form-group">
                    <input type="number" name="value" required>
                    <label>Value</label>
                </div>
                <div class="form-group">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        <h3>Templates Name</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Template Name</th>
                        <th>Component Name</th>
                        <th>Type</th>
                        <th>Calculation Type</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($componentdata as $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $items->template_name }}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->type }}</td>
                            <td>{{ $items->calculation_type }}</td>
                            <td>{{ $items->value }}</td>
                            <td><button class="edit-icon" onclick="openEditBranchModal()">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showSalaryComponentForm() {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
    }

    function showSalaryComponentTable() {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
    }

    // Ensure the form is visible by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        showSalaryComponentForm();
    });
</script>

@endsection


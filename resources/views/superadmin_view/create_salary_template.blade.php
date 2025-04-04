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
    <h2>Creates Salary Templates</h2>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button class="but" onclick="showSalaryTemplateForm()">Show Form</button>
        <button class="but" onclick="showSalaryTemplateTable()">Show Table</button>
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

        <form method="POST" action="{{ route('insert_salary_template') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="text" name="template_name" required>
                    <label>Name</label>
                </div>
                <div class="form-group">
                    <input type="number" name="min_ctc" required>
                    <label>Min CTC</label>
                </div>
                <div class="form-group">
                    <input type="number" name="max_ctc" required>
                    <label>Max CTC</label>
                </div>
                <div class="form-group">
                    <select name="status" required>
                        <option value="" disabled selected></option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label>Status</label>
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
                        <th>Name</th>
                        <th>Min CTC</th>
                        <th>Max CTC</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($template_datas as $template)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->min_ctc }}</td>
                            <td>{{ $template->max_ctc }}</td>
                            <td>{{ $template->status }}</td>
                            <td><button class="edit-icon" onclick="openEditBranchModal()">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showSalaryTemplateForm() {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
    }

    function showSalaryTemplateTable() {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
    }

    // Ensure the form is visible by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        showSalaryTemplateForm();
    });
</script>

@endsection


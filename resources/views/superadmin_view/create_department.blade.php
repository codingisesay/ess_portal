@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

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
    <h2>Create Department For Your Organisation</h2>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button class="but" onclick="showDepartmentForm()">Show Form</button>
        <button class="but" onclick="showDepartmentTable()">Show Table</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" style="display: none;">
        <form method="POST" action="{{ route('insert_department') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{$id}}">
                    <input type="text" name="department_name" required>
                    <label>Department Name</label>
                </div>
                <div class="form-group" style="position: relative; bottom:8px;">
                    <button class="create-btn" type="submit">Create Department</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        <h3>Organisation Departments</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $index => $department)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $department->id }}</td>
                            <td>{{ $department->name }}</td>
                            <td><button class="edit-icon" onclick="openEditDepartmentModal({{ $department }})">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showDepartmentForm() {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
    }

    function showDepartmentTable() {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
    }

    // Ensure the form is visible by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        showDepartmentForm();
    });

    function openEditDepartmentModal(department) {
        document.getElementById('editDepartmentId').value = department.id;
        document.getElementById('editDepartmentName').value = department.name;
        document.getElementById('editDepartmentModal').style.display = 'block';
    }
</script>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editDepartmentModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Department</h2>
        </header>
        <div class="w3-container">
            <form id="editDepartmentForm" action="{{ route('update_department') }}" method="POST">
                @csrf
                <input type="hidden" name="department_id" id="editDepartmentId">
                <div class="popup-form-group">
                    <label for="editDepartmentName">Department Name</label>
                    <input type="text" name="department_name" id="editDepartmentName" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


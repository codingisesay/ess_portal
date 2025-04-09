@extends('superadmin_view/superadmin_layout')  
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

<div class="container">
    <h3>Create Designation For Your Organisation</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showDesignationTable(this)">Show Table</button>
        <button onclick="showDesignationForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" >
        <form method="POST" action="{{ route('insert_designation') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{$id}}">
                    <select name="department_id" required>
                        <option value="" disabled selected></option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <label>Department</label>
                </div>
                <div class="form-group">
                    <select name="branch_id" required>
                        <option value="" disabled selected></option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <label>Location Name</label>
                </div>
                <div class="form-group">
                    <input type="text" name="name" placeholder=" " required>
                    <label>Designation Name</label>
                </div>
                <div class="form-group" >
                    <button class="create-btn" type="submit">Create Designation</button>
                </div>
            </div>
        </form>
    </div>
 
    <div id="tableSection"  >
        @include('partials.data_table', [
            'items' => $results,
            'columns' => [
                ['header' => 'Designation', 'accessor' => 'department_name'],
                ['header' => 'Branch', 'accessor' => 'branch_name'],
                ['header' => 'Designation', 'accessor' => 'designation_name'], 
            ],
            'editModalId' => 'openEditModal',
            'hasPermision' => true,
            'perPage' => 5
        ])
    </div>
    <!-- Table Section -->
    <div id="tableSection" > 
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Department Name</th>
                        <th>Branch Name</th>
                        <th>Designation Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result->department_name }}</td>
                            <td>{{ $result->branch_name }}</td>
                            <td>{{ $result->designation_name }}</td>
                            <td>
                                <form action="{{ route('create_permission_form', ['org_id' => $id, 'desig_id' => $result->designation_id, 'b_id' => $result->branch_id]) }}">
                                    @csrf
                                    <button class="create-btn" type="submit">Permission</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popup">
    <div class="popup-content" style="z-index:auto">
        <div class="popup-header">
            <h4 class="fw-bold">Create Permission</h4>
            <button class="popup-close" onclick="closePopup()">&times;</button>
        </div> 
    </div>
</div>

<script>
    function showDesignationForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showDesignationTable(clickedElement) {
        
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
        showDesignationTable(firstButton);
    });
 
 
    function openEditModal() { 
        document.getElementById('popup').style.display = 'block';
    }
</script>

@endsection




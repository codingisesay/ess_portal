@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <h2>Create Designation For Your Organisation</h2>
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
                <label>Branch Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="name" placeholder=" " required>
                <label>Designation Name</label>
            </div>
            <div class="form-group">
                <button class="create-btn" type="submit">Create Designation</button>
            </div>
        </div>
    </form>

    @if($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h3>Organisation Designations</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Branch Name</th>
                    <th>Designation Name</th>
                    <th>Edit Permissions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
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

<style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f3f6;
    margin: 0;
    padding: 40px;
    display: flex;
}

.container {
    width: calc(100% - 250px);
    /* Adjust width to account for sidebar */
    margin-left: 30px; 
    /* Add left margin to make space for sidebar */
    padding: 0px;
}

/* Form Styling */
h2 {
    color: #333;
    margin-bottom: 2%;
}

.form-container {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    margin-bottom: 15px;
}

.form-group {
    position: relative;
    width: calc(33.33% - 15%);
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background: transparent;
    outline: none;
    appearance: none;
}

.form-group label {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    background: #f6f6f6;
    color: #aaa;
    font-size: 14px;
    pointer-events: none;
    transition: all 0.3s ease;
}

/* Floating Labels Effect */
.form-group input:focus+label,
.form-group input:valid+label,
.form-group select:focus+label,
.form-group select:valid+label {
    top: 0px;
    left: 10px;
    font-size: 15px;
    color: #000000;
}

/* Create Button */
.create-btn {
    background-color: #8A3366;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    display: block;
    margin-top: 0px;
}

.create-btn:hover {
    background-color: #702851;
}

/* Table Styling */
h3 {
    margin-top: 30px;
    color: #333;
}

.table-container {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
    /* Enable horizontal scrolling */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    min-width: 600px;
    /* Prevents table from being too small */
    border: 1px solid #ddd;
    /* Table border */
}

thead {
    background-color: #d49da7;
    color: white;
}

th,
td {
    padding: 10px;
    text-align: left;
    white-space: nowrap;
    /* Prevents text from wrapping in small screens */
    border: 1px solid #ddd;
    /* Row and column borders */
}

th {
    font-weight: bold;
}

tbody tr:nth-child(even) {
    background-color: #f8f8f8;
}

/* Edit Icon */
.edit-icon {
    color: #8A3366;
    cursor: pointer;
    font-size: 18px;
}

.edit-icon:hover {
    color: #702851;
}

/* 🔹 RESPONSIVE DESIGN */
@media screen and (max-width: 1024px) {
    .form-group {
        width: calc(50% - 10px);
        /* 2 fields per row */
    }
}

@media screen and (max-width: 768px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        margin-left: 0;
        border-radius: 0;
    }

    .container {
        width: 100%;
        margin-left: 0;
        padding: 10px;
    }

    .form-group {
        width: 100%;
        /* Stacks inputs */
    }

    .create-btn {
        width: 100%;
        text-align: center;
    }

    .table-container {
        overflow-x: auto;
        /* Table scrolls horizontally */
    }
}
</style>

@endsection




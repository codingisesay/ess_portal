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

<div class="container">
    <h2>Create Designation For Your Organisation</h2>

    @if(session('success'))
    <div class="alert custom-alert-success">
        <strong>{{ session('success') }}</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        
    </div>
@endif

@if(session('error'))
<div class="alert custom-alert-error">
    <strong> {{ session('error') }}</strong>
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

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
            <div class="form-group" style="position: relative; bottom:8px;">
                <button class="create-btn" type="submit">Create Designation</button>
            </div>
        </div>
    </form>

    <h3>Organisation Designations</h3>
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


@endsection




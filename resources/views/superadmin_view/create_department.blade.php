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
    <h2>Create Department For Your Organisation</h2>

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
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection


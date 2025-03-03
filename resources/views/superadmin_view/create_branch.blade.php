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
<div class="container">
    <h2>Create Branches For Your Organisation</h2>
    
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

    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif


    <form method="POST" action="{{ route('insert_branch') }}">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <input type="text" name="branchname" required>
                <label>Branch Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="mobile" required>
                <label>Mobile</label>
            </div>
            <div class="form-group">
                <input type="email" name="branchmailid" required>
                <label>Branch Email</label>
            </div>
            <div class="form-group">
                <input type="text" name="Building_No" value="" required>
                <label>Building No</label>
            </div>
        </div>
        <div class="form-container">
           
            <div class="form-group">
                <input type="text" name="premises_name" required>
                <label>Premises Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="landmark" required>
                <label>Landmark</label>
            </div>
            <div class="form-group">
                <input type="text" name="road_street" required>
                <label>Road Street</label>
            </div>
            <div class="form-group">
                <input type="text" name="pincode" required>
                <label>Pincode</label>
            </div>
        </div>
        <div class="form-container">
            
            <div class="form-group">
                <input type="text" name="district" required>
                <label>District</label>
            </div>
            <div class="form-group">
                <input type="text" name="state" required>
                <label>State</label>
            </div>
            <div class="form-group">
                <input type="text" name="country" required>
                <label>Country</label>
            </div>
        </div>
        <div class="form-container">
           
            <div class="form-group">
                <button class="create-btn" type="submit">Create Branch</button>
            </div>
        </div>
    </form>

   

    <h3>Branch</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>E-mail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branchs as $index => $branch)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->mobile }}</td>
                        <td>{{ $branch->branch_email }}</td>
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection


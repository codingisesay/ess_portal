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
    <form method="POST" action="{{ route('insert_designation') }}">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <input type="text" name="username" required>
                <label>Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="empid" required>
                <label>Mobile</label>
            </div>
            <div class="form-group">
                <input type="email" name="usermailid" required>
                <label>Branch Email</label>
            </div>
            <div class="form-group">
                <input type="text" name="userpassword" value="" readonly>
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

    @if($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h3>Branch</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>E-mail</th>
                    <th>Edit</th>
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


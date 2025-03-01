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
    <h2>Create User Of Your Organisation</h2>

    {{-- <div class="alert custom-alert-success">
        <strong>Success! This alert box could indicate a successful or positive action.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    
    <div class="alert custom-alert-error">
        <strong>Error! Something went wrong. Please try again later.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
    
    <div class="alert custom-alert-warning">
        <strong>Warning! Be cautious when making changes. Please double-check your input.</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div> --}}

    @if(session('success'))
    <div class="alert custom-alert-success">
        <strong> {{ session('success') }}</strong> 
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

@if(session('error'))
<div class="alert custom-alert-error">
    <strong>{{ session('error') }}</strong> 
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif
    <form action="{{ route('register_save') }}" method="POST">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <input type="hidden" name="organisation_id" value="{{$id}}">
                <input type="text" name="username" required>
                <label>Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="empid" required>
                <label>Company Emp ID</label>
            </div>
            <div class="form-group">
                <input type="email" name="usermailid" required>
                <label>Email</label>
            </div>
            <div class="form-group">
                <input type="text" id="passwordField" name="userpassword" value="akash@1234" readonly>
                <label>Password</label>
            </div>
        </div>
        <div class="form-container">
            
            <div class="form-group">
                <a href="#" onclick="generateAndDisplayPassword()">Generate Password</a>
            </div>
            <div class="form-group">
                <button class="create-btn" type="submit">Create User</button>
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

    <h3>Users</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function generateSecurePassword(length = 12) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        const array = new Uint32Array(length);
        window.crypto.getRandomValues(array);
        return Array.from(array, (num) => chars[num % chars.length]).join('');
    }

    function generateAndDisplayPassword() {
        const password = generateSecurePassword(12);
        document.getElementById('passwordField').value = password;
    }
</script>

@endsection



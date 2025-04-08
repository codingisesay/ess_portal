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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container">
<h3>Create User Of Your Organisation</h2>
    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showUserTable(this)">Show Table</button>
        <button onclick="showUserForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" >
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
                    <input type="text" id="passwordField" name="userpassword" readonly>
                    <label>Password</label>
                </div>
                <div class="form-group">
                    <a href="#" onclick="generateAndDisplayPassword()">Generate Password</a>
                </div>
                <div class="form-group">
               
                </div>
                <button class="create-btn" type="submit">Create User</button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" > 
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
                            <td>
                                <!-- <button class="edit-icon" onclick="openEditUserModal({{ $user }})">Edit</button> -->
                            <i class="bi bi-pencil-square" onclick="openEditUserModal({{ $user }})"></i>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showUserForm(clickedElement) {
        // Show form section and hide table section
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none'; 
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showUserTable(clickedElement) {
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
        showUserTable(firstButton);
    });
    
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

    function openEditUserModal(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editUsername').value = user.name;
        document.getElementById('editEmpid').value = user.employeeID;
        document.getElementById('editUsermailid').value = user.email;
        document.getElementById('editUserModal').style.display = 'block';
    }
</script>

@endsection



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
<!-- <link rel="stylesheet" href="{{ asset('bootstrapcss/bootstrap.min.css') }}"> -->
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
            <div class="form-container row">
                <div class="col-3 mb-2">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{$id}}">
                    <input type="text" name="username" required>
                    <label>Name</label>
                </div>
                </div>
                <div class="col-3 mb-2">
                <div class="form-group">
                    <input type="text" name="empid" required>
                    <label>Company Emp ID</label>
                </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <input type="email" name="usermailid" required>
                        <label>Email</label>
                    </div>
                </div>
                <div class="col-3 mb-2">
                <div class="form-group">
                    <input type="text" id="passwordField" name="userpassword" readonly>
                    <label>Password</label> 
                </div>
                <small> <a href="#" onclick="generateAndDisplayPassword()">Generate Password</a></small>
                </div>
                 
                <div class="col-3 mb-2">
                <div class="form-group">
                        <input type="hidden" name="organisation_id" value="1">
                        <select name="acct_allow" required="" fdprocessedid="kg1mb">
                            <option value="" disabled="" selected=""></option>
                                    <option value="1">Not Allow</option>
                                    <option value="2">Allowed</option> 
                            </select>
                        <label>Account Access</label>
                    </div>
                </div>
                <div class="col-12">
                <button class="create-btn" type="submit">Create User</button>
            </div>
            </div>
        </form>
    </div>
 
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $users,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Email', 'accessor' => 'email'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
 <!-- Edit User Modal -->
<div id="editUserModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal">
            <span onclick="document.getElementById('editUserModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit User</h2>
        </header>
        <div class="w3-container">
            <form id="editUserForm" action="{{ route('update_user') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="editUserId">
                <div class="popup-form-group">
                    <input type="text" name="username" id="editUsername" required>
                    <label for="editUsername">Username</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="empid" id="editEmpid" required>
                    <label for="editEmpid">Employee ID</label>
                </div>
                <div class="popup-form-group">
                    <input type="email" name="usermailid" id="editUsermailid" required>
                    <label for="editUsermailid">User Email</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
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

    function openEditModal(user, userdata) { 
        document.getElementById('editUserId').value = userdata.id;
        document.getElementById('editUsername').value = userdata.name;
        document.getElementById('editEmpid').value = userdata.employeeID;
        document.getElementById('editUsermailid').value = userdata.email;
        document.getElementById('editUserModal').style.display = 'block';
    }
</script>

@endsection



@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
error_reporting(0);
$id = Auth::guard('superadmin')->user()->id;

// echo $mailDatas[0]->MAIL_MAILER;
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
    <h2>Configure Mail Settings</h2>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button class="but" onclick="showMailConfigForm()">Show Form</button>
        <button class="but" onclick="showMailConfigTable()">Show Table</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" style="display: none;">
        <form action="{{ route('insert_configuration') }}" method="POST">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{$id}}">
                    <input type="text" name="MAIL_MAILER" required>
                    <label>MAIL_MAILER</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_HOST" required>
                    <label>MAIL_HOST</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_PORT" required>
                    <label>MAIL_PORT</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_USERNAME" required>
                    <label>MAIL_USERNAME</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_PASSWORD" required>
                    <label>MAIL_PASSWORD</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_ENCRYPTION" required>
                    <label>MAIL_ENCRYPTION</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_FROM_ADDRESS" required>
                    <label>MAIL_FROM_ADDRESS</label>
                </div>
                <div class="form-group">
                    <input type="text" name="MAIL_FROM_NAME" required>
                    <label>MAIL_FROM_NAME</label>
                </div>
                <div class="form-group">
                    <button class="create-btn" type="submit" <?php echo $status = ($mailDatas[0]->MAIL_MAILER == "") ? ('') : ('disabled');  ?>>Configure</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display: none;">
        <h3>Configuration</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>MAILER</th>
                        <th>HOST</th>
                        <th>PORT</th>
                        <th>USERNAME</th>
                        {{-- <th>PASSWORD</th> --}}
                        <th>ENCRYPTION</th>
                        <th>FROM ADDRESS</th>
                        <th>FROM NAME</th>
                        <th>EDIT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $mailDatas[0]->MAIL_MAILER }}</td>
                        <td>{{ $mailDatas[0]->MAIL_HOST }}</td>
                        <td>{{ $mailDatas[0]->MAIL_PORT }}</td>
                        <td>{{ $mailDatas[0]->MAIL_USERNAME }}</td>
                        {{-- <td>{{ $mailDatas[0]->MAIL_PASSWORD }}</td> --}}
                        <td>{{ $mailDatas[0]->MAIL_ENCRYPTION }}</td>
                        <td>{{ $mailDatas[0]->MAIL_FROM_ADDRESS }}</td>
                        <td>{{ $mailDatas[0]->MAIL_FROM_NAME }}</td>
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showMailConfigForm() {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
    }

    function showMailConfigTable() {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
    }

    // Ensure the form is visible by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        showMailConfigForm();
    });
</script>

@endsection



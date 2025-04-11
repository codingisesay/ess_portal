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
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">

<div class="container">
    <h3>Configure Mail Settings</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showMailConfigTable(this)">Show Table</button>
        <button onclick="showMailConfigForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" >
        <form action="{{ route('insert_configuration') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="hidden" name="organisation_id" value="{{$id}}">
                        <input type="text" name="MAIL_MAILER" required>
                        <label>MAIL_MAILER</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_HOST" required>
                        <label>MAIL_HOST</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_PORT" required>
                        <label>MAIL_PORT</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_USERNAME" required>
                        <label>MAIL_USERNAME</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_PASSWORD" required>
                        <label>MAIL_PASSWORD</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_ENCRYPTION" required>
                        <label>MAIL_ENCRYPTION</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_FROM_ADDRESS" required>
                        <label>MAIL_FROM_ADDRESS</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="MAIL_FROM_NAME" required>
                        <label>MAIL_FROM_NAME</label>
                    </div>
                </div>
              
                <div class="col-12">
                    <button class="create-btn" type="submit" <?php echo $status = ($mailDatas[0]->MAIL_MAILER == "") ? ('') : ('disabled');  ?>>Configure</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $mailDatas,
            'columns' => [
                ['header' => 'Mailer', 'accessor' => 'MAIL_MAILER'],
                ['header' => 'Host', 'accessor' => 'MAIL_HOST'],
                ['header' => 'Port', 'accessor' => 'MAIL_PORT'],
                ['header' => 'Username', 'accessor' => 'MAIL_USERNAME'],
                ['header' => 'Encryption', 'accessor' => 'MAIL_ENCRYPTION'],
                ['header' => 'From Address', 'accessor' => 'MAIL_FROM_ADDRESS'],
                ['header' => 'From Name', 'accessor' => 'MAIL_FROM_NAME'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true, 
            'perPage' => 5
        ])
    </div>

</div>

<div id="editMailConfigModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editMailConfigModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Mail Configuration</h2>
        </header>
        <div class="w3-container">
            <form id="editMailConfigForm" action="{{ route('update_configuration') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="organisation_id" value="{{ $id }}">
                <div class="popup-form-group">
                    <label for="editMailMailer">MAIL_MAILER</label>
                    <input type="text" name="MAIL_MAILER" id="editMailMailer" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailHost">MAIL_HOST</label>
                    <input type="text" name="MAIL_HOST" id="editMailHost" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailPort">MAIL_PORT</label>
                    <input type="text" name="MAIL_PORT" id="editMailPort" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailUsername">MAIL_USERNAME</label>
                    <input type="text" name="MAIL_USERNAME" id="editMailUsername" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailPassword">MAIL_PASSWORD</label>
                    <input type="text" name="MAIL_PASSWORD" id="editMailPassword" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailEncryption">MAIL_ENCRYPTION</label>
                    <input type="text" name="MAIL_ENCRYPTION" id="editMailEncryption" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailFromAddress">MAIL_FROM_ADDRESS</label>
                    <input type="text" name="MAIL_FROM_ADDRESS" id="editMailFromAddress" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMailFromName">MAIL_FROM_NAME</label>
                    <input type="text" name="MAIL_FROM_NAME" id="editMailFromName" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showMailConfigForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showMailConfigTable(clickedElement) {
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
        showMailConfigTable(firstButton);
    });
 
    function openEditModal(mailer, datas) {
        document.getElementById('editMailMailer').value = datas.MAIL_MAILER;
        document.getElementById('editMailHost').value = datas.MAIL_HOST;
        document.getElementById('editMailPort').value = datas.MAIL_PORT;
        document.getElementById('editMailUsername').value = datas.MAIL_USERNAME; 
        document.getElementById('editMailEncryption').value = datas.MAIL_ENCRYPTION;
        document.getElementById('editMailFromAddress').value = datas.MAIL_FROM_ADDRESS;
        document.getElementById('editMailFromName').value = datas.MAIL_FROM_NAME;

        document.getElementById('editMailConfigModal').style.display = 'block';
    }
</script>

@endsection



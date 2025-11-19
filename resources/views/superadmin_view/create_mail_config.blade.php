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
<style>
    .search-container {
        position: relative;
        margin-left: 10px;
    }
    .search-box {
        display: flex;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
        width: 40px;
        overflow: hidden;
    }
    .search-box.expanded {
        width: 250px;
    }
    .search-icon {
        position: absolute;
        left: 10px;
        cursor: pointer;
        z-index: 2;
        width: 20px;
        height: 20px;
    }
    .search-input {
        padding-left: 40px;
        width: 100%;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }
    .search-box.expanded .search-input {
        opacity: 1;
        visibility: visible;
    }
    .d-flex {
        display: flex !important;
        align-items: center;
        gap: 15px;
        margin-bottom: 1.5rem;
    }
    .toggle-buttons {
        display: flex;
        gap: 10px;
    }
</style>

<div class="container">
    <h3>Configure Mail Settings</h3>

    <div class="d-flex">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="active" onclick="showMailConfigForm(this)">Show Form</button>
            <button onclick="showMailConfigTable(this)">Show Table</button>
        </div>
        
        <!-- Search Box with Icon (initially hidden) -->
        <div class="search-container" id="tableSearchContainer" style="display: none;">
            <div class="search-box">
                <img src="{{ asset('user_end/images/search (1).png') }}" alt="Search" class="search-icon" id="searchIcon">
                <input type="text" id="tableSearch" placeholder="Search..." class="search-input">
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="formSection">
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
    <div id="tableSection" style="display: none;">
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
                    <input type="text" name="MAIL_MAILER" id="editMailMailer" required>
                    <label for="editMailMailer">MAIL_MAILER</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_HOST" id="editMailHost" required>
                    <label for="editMailHost">MAIL_HOST</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_PORT" id="editMailPort" required>
                    <label for="editMailPort">MAIL_PORT</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_USERNAME" id="editMailUsername" required>
                    <label for="editMailUsername">MAIL_USERNAME</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_PASSWORD" id="editMailPassword" required>
                    <label for="editMailPassword">MAIL_PASSWORD</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_ENCRYPTION" id="editMailEncryption" required>
                    <label for="editMailEncryption">MAIL_ENCRYPTION</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_FROM_ADDRESS" id="editMailFromAddress" required>
                    <label for="editMailFromAddress">MAIL_FROM_ADDRESS</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="MAIL_FROM_NAME" id="editMailFromName" required>
                    <label for="editMailFromName">MAIL_FROM_NAME</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Search box toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const searchIcon = document.getElementById('searchIcon');
        const searchInput = document.getElementById('tableSearch');
        
        if (searchIcon && searchInput) {
            // Toggle search box on icon click
            searchIcon.addEventListener('click', function() {
                searchBox.classList.toggle('expanded');
                if (searchBox.classList.contains('expanded')) {
                    // Focus the input when expanding
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                }
            });
            
            // Close search when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target) && searchBox.classList.contains('expanded')) {
                    searchBox.classList.remove('expanded');
                }
            });
            
            // Prevent search box from closing when clicking inside it
            searchInput.addEventListener('click', function(event) {
                event.stopPropagation();
            });
            
            // Handle search input
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableSection tbody tr');
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let rowMatches = false;
                    
                    // Skip the action column (last cell)
                    for (let i = 0; i < cells.length - 1; i++) {
                        const cellText = cells[i].textContent.toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            rowMatches = true;
                            break;
                        }
                    }
                    
                    row.style.display = rowMatches ? '' : 'none';
                });
            });
        }
        
        // Show form by default on page load
        showMailConfigForm(document.querySelector('.toggle-buttons button:first-child'));
    });

    function showMailConfigForm(clickedElement) {
        // Show form section and hide table section
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        
        // Hide search container
        document.getElementById('tableSearchContainer').style.display = 'none';
        
        // Collapse search box if it's expanded
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.classList.remove('expanded');
        }
        
        updateActiveButton(clickedElement);
    }

    function showMailConfigTable(clickedElement) {
        // Show table section and hide form section
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        
        // Show search container when table is shown
        document.getElementById('tableSearchContainer').style.display = 'block';
        
        updateActiveButton(clickedElement);
        
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    // Show form by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showMailConfigForm(firstButton);
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
    
    function updateActiveButton(clickedElement) {
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }
</script>

@endsection



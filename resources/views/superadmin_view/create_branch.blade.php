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
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<div class="container">
    <h3>Create Branches For Your Organisation</h3>

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
    </style>

    <div class="d-flex justify-content-start align-items-center mb-4" style="gap: 15px;">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button onclick="showBranchForm(this)" class="active">Show Form</button>
            <button onclick="showBranchTable(this)">Show Table</button>
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
    <div id="formSection" >
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_branch') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="branchname" required>
                        <label>Branch Name</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="mobile" required>
                        <label>Mobile</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="email" name="branchmailid" required>
                        <label>Branch Email</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="Building_No" value="" required>
                        <label>Building No</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="premises_name" required>
                        <label>Premises Name</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="landmark" required>
                        <label>Landmark</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="road_street" required>
                        <label>Road Street</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="pincode" required>
                        <label>Pincode</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="district" required>
                        <label>District</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="state" required>
                        <label>State</label>
                    
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="country" required>
                        <label>Country</label>
                    
                    </div>
                </div>
               
                <div class="col-12">
                    <button class="create-btn" type="submit">Create Branch</button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $branchs,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Mobile', 'accessor' => 'mobile'],
                ['header' => 'Email', 'accessor' => 'branch_email'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
 
</div>

<!-- Edit Branch Modal -->
<div id="editBranchModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editBranchModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Branch</h2>
        </header>
        <div class="w3-container">
            <form id="editBranchForm" action="{{ route('update_branch') }}" method="POST">
                @csrf
                <input type="hidden" name="branch_id" id="editBranchId">
                <div class="popup-form-group">
                    <input type="text" name="branchname" id="editBranchName" required>
                    <label for="editBranchName">Branch Name</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="mobile" id="editMobile" required>
                    <label for="editMobile">Mobile</label>
                </div>
                <div class="popup-form-group">
                    <input type="email" name="branchmailid" id="editBranchEmail" required>
                    <label for="editBranchEmail">Branch Email</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="Building_No" id="editBuildingNo" required>
                    <label for="editBuildingNo">Building No</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="premises_name" id="editPremisesName" required>
                    <label for="editPremisesName">Premises Name</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="landmark" id="editLandmark" required>
                    <label for="editLandmark">Landmark</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="road_street" id="editRoadStreet" required>
                    <label for="editRoadStreet">Road Street</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="pincode" id="editPincode" required>
                    <label for="editPincode">Pincode</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="district" id="editDistrict" required>
                    <label for="editDistrict">District</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="state" id="editState" required>
                    <label for="editState">State</label>
                </div>
                <div class="popup-form-group">
                    <input type="text" name="country" id="editCountry" required>
                    <label for="editCountry">Country</label>
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
        }
    });

    function showBranchForm(clickedElement) {
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
        
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showBranchTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        // Show search container when table is shown
        document.getElementById('tableSearchContainer').style.display = 'block';
        
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    // Ensure the form is visible by default on page load
   
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showBranchForm(firstButton);
    });
     

    function openEditModal(id ,branch) {
        document.getElementById('editBranchId').value = branch.id;
        document.getElementById('editBranchName').value = branch.name;
        document.getElementById('editMobile').value = branch.mobile;
        document.getElementById('editBranchEmail').value = branch.branch_email;
        document.getElementById('editBuildingNo').value = branch.building_no;
        document.getElementById('editPremisesName').value = branch.premises_name;
        document.getElementById('editLandmark').value = branch.landmark;
        document.getElementById('editRoadStreet').value = branch.road_street;
        document.getElementById('editPincode').value = branch.pincode;
        document.getElementById('editDistrict').value = branch.district;
        document.getElementById('editState').value = branch.state;
        document.getElementById('editCountry').value = branch.country;
        document.getElementById('editBranchModal').style.display = 'block';
    }
</script>

@endsection


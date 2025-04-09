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

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showBranchTable(this)">Show Table</button>
        <button onclick="showBranchForm(this)">Show Form</button>
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
                <div class="form-group">
                    <button class="create-btn" type="submit">Create Branch</button>
                </div>
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
                            <td>
                            <button onclick="openEditBranchModal({{ $branch }})" class="btn">  <x-icon name="edit" /> </button>  
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
                    <label for="editBranchName">Branch Name</label>
                    <input type="text" name="branchname" id="editBranchName" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMobile">Mobile</label>
                    <input type="text" name="mobile" id="editMobile" required>
                </div>
                <div class="popup-form-group">
                    <label for="editBranchEmail">Branch Email</label>
                    <input type="email" name="branchmailid" id="editBranchEmail" required>
                </div>
                <div class="popup-form-group">
                    <label for="editBuildingNo">Building No</label>
                    <input type="text" name="Building_No" id="editBuildingNo" required>
                </div>
                <div class="popup-form-group">
                    <label for="editPremisesName">Premises Name</label>
                    <input type="text" name="premises_name" id="editPremisesName" required>
                </div>
                <div class="popup-form-group">
                    <label for="editLandmark">Landmark</label>
                    <input type="text" name="landmark" id="editLandmark" required>
                </div>
                <div class="popup-form-group">
                    <label for="editRoadStreet">Road Street</label>
                    <input type="text" name="road_street" id="editRoadStreet" required>
                </div>
                <div class="popup-form-group">
                    <label for="editPincode">Pincode</label>
                    <input type="text" name="pincode" id="editPincode" required>
                </div>
                <div class="popup-form-group">
                    <label for="editDistrict">District</label>
                    <input type="text" name="district" id="editDistrict" required>
                </div>
                <div class="popup-form-group">
                    <label for="editState">State</label>
                    <input type="text" name="state" id="editState" required>
                </div>
                <div class="popup-form-group">
                    <label for="editCountry">Country</label>
                    <input type="text" name="country" id="editCountry" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showBranchForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none'; 
    const siblings = clickedElement.parentElement.children;
    for (let sibling of siblings) {
        sibling.classList.remove('active');
    } 
    clickedElement.classList.add('active');
    }

    function showBranchTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block'; 
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
        showBranchTable(firstButton);
    });
     

    function openEditBranchModal(branch) {
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


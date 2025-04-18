@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}"> 
    
</head>
<body>
    <div class="container">
        <h3>Create Leave Type</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showLeaveTypeTable(this)">Show Table</button>
            <button onclick="showLeaveTypeForm(this)">Show Form</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" class="text-danger">
            @if($errors->any())
            <div class="alert custom-alert-warning">
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('insert_policy_type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div  class="form-container row">
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="cycle_slot_id" class="form-control" required>
                                <option value="" disabled selected></option>
                                @foreach ($leaveCycleDatas as $leaveCycleData)
                                <option value="{{$leaveCycleData->id}}">{{ $leaveCycleData->name }}</option>
                                @endforeach
                            </select>
                            <label for="category_id">Select Cycle</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="text" id="category_name" name="leave_category" class="form-control" required>
                            <label for="category_name">Leave Type Name</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="half_day_status" class="form-control" required>
                                <option value="" disabled selected></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="category_name">Half Day Applicable?</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="status" class="form-control" required>
                                <option value="" disabled selected></option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <label for="category_id">Status</label>
                        </div>
                    </div>
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Type</button></div>
                </div>
            </form>
        </div>
    
        <!-- Table Section -->
        <div id="tableSection">
            @include('partials.data_table', [
                'items' => $results,
                'columns' => [  
                    ['header' => 'ID', 'accessor' => 'id'],
                    ['header' => 'Cycle Name', 'accessor' => 'leave_cycle_name'],
                    ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                    ['header' => 'Half Day', 'accessor' => 'leave_half_status'],
                    ['header' => 'Status', 'accessor' => 'leave_status'],
                ],
                'editModalId' => 'openEditModal',
                'hasActions' => true,
                'perPage' => 5,
                'actionCallback' => function($item) {
                    return "openEditModal(" . json_encode($item) . ")";
                }
            ])
        </div>
    

        <div id="editLeaveTypeModal" class="w3-modal" style="display: none;">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-teal"> 
                    <span onclick="document.getElementById('editLeaveTypeModal').style.display='none'" 
                    class="w3-button w3-display-topright">&times;</span>
                    <h2>Edit Leave Type</h2>
                </header>
                <div class="w3-container">
                    <form id="editLeaveTypeForm" method="POST" action="{{ route('update_policy_type') }}">
                        @csrf
                        <input type="hidden" name="leave_type_id" id="editLeaveTypeId"> <!-- Hidden input for leave_type_id -->
                        <div class="popup-form-group">
                            <select name="cycle_slot_id" id="editLeaveCycle" required>
                                @foreach ($leaveCycleDatas as $leaveCycleData)
                                    <option value="{{ $leaveCycleData->id }}">{{ $leaveCycleData->name }}</option>
                                @endforeach
                            </select>
                            <label for="editLeaveCycle">Select Cycle</label>
                        </div>
                        <div class="popup-form-group">
                            <input type="text" name="leave_category" id="editLeaveTypeName" required>
                            <label for="editLeaveTypeName">Leave Type Name</label>
                        </div>
                        <div class="popup-form-group">
                            <select name="half_day_status" id="editHalfDayStatus" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="editHalfDayStatus">Half Day Applicable?</label>
                        </div>
                        <div class="popup-form-group">
                            <select name="status" id="editLeaveStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <label for="editLeaveStatus">Status</label>
                        </div>
                        <div class="popup-form-group">
                            <button class="create-btn1" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function showLeaveTypeForm(clickedElement) {
                document.getElementById('formSection').style.display = 'block';
                document.getElementById('tableSection').style.display = 'none';
                const siblings = clickedElement.parentElement.children;
                for (let sibling of siblings) {
                    sibling.classList.remove('active');
                }
                clickedElement.classList.add('active');
            }

            function showLeaveTypeTable(clickedElement) {
                document.getElementById('formSection').style.display = 'none';
                document.getElementById('tableSection').style.display = 'block';
                const siblings = clickedElement.parentElement.children;
                for (let sibling of siblings) {
                    sibling.classList.remove('active');
                }
                clickedElement.classList.add('active');
            }

            // Ensure the first button (Show Table) is active by default on page load
            document.addEventListener('DOMContentLoaded', () => {
                const firstButton = document.querySelector('.toggle-buttons button:first-child');
                showLeaveTypeTable(firstButton);
            });

            function openEditModal(results, levtyps) {
                document.getElementById('editLeaveTypeId').value = levtyps.leave_type_id; // Set the leave_type_id
                document.getElementById('editLeaveCycle').value = levtyps.leave_cycle_id; // Set the cycle ID
                document.getElementById('editLeaveTypeName').value = levtyps.leave_type; // Set the leave type name
                document.getElementById('editHalfDayStatus').value = levtyps.leave_half_status; // Set the half-day status
                document.getElementById('editLeaveStatus').value = levtyps.leave_status; // Set the status

                document.getElementById('editLeaveTypeModal').style.display = 'block'; // Show the modal
            }
        </script>
@endsection
</body>
</html>

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
    <title>Create Policy Category</title>
    
</head>
<body>
    <div class="container">
        <h1>Create Leave Type</h1>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="but" onclick="showLeaveTypeForm()">Show Form</button>
            <button class="but" onclick="showLeaveTypeTable()">Show Table</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" style="display: none;">
            @if($errors->any())
            <div class="alert custom-alert-warning">
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('insert_policy_type') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <select id="category_id" name="cycle_slot_id" class="form-control" required>
                        <option value="" disabled selected></option>
                        @foreach ($leaveCycleDatas as $leaveCycleData)
                        <option value="{{$leaveCycleData->id}}">{{ $leaveCycleData->name }}</option>
                        @endforeach
                    </select>
                    <label for="category_id">Select Cycle</label>
                </div>
                <div class="form-group">
                    <input type="text" id="category_name" name="leave_category" class="form-control" required>
                    <label for="category_name">Leave Type Name</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="half_day_status" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="category_name">Half Day Applicable?</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="status" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="category_id">Status</label>
                </div>
                <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Type</button>
            </form>
        </div>

        <!-- Table Section -->
        <div id="tableSection" style="display: none;">
            <h3>Leave Type</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Cycle Name</th>
                            <th>Leave Type</th>
                            <th>Half Day</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result->leave_cycle_name }}</td>
                                <td>{{ $result->leave_type }}</td>
                                <td>{{ $result->leave_half_status }}</td>
                                <td>{{ $result->leave_status }}</td>
                                <td>
                                    <button class="edit-icon" onclick="openEditLeaveTypeModal({{ $result->leave_type_id }}, '{{ $result->leave_cycle_id }}', '{{ $result->leave_type }}', '{{ $result->leave_half_status }}', '{{ $result->leave_status }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editLeaveTypeModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeaveTypeModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Type</h2>
            </header>
            <div class="w3-container">
                <form id="editLeaveTypeForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="leave_type_id" id="editLeaveTypeId">
                    <div class="popup-form-group">
                        <label for="editLeaveCycle">Select Cycle</label>
                        <select name="cycle_slot_id" id="editLeaveCycle" required>
                            @foreach ($leaveCycleDatas as $leaveCycleData)
                                <option value="{{ $leaveCycleData->id }}">{{ $leaveCycleData->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveTypeName">Leave Type Name</label>
                        <input type="text" name="leave_category" id="editLeaveTypeName" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editHalfDayStatus">Half Day Applicable?</label>
                        <select name="half_day_status" id="editHalfDayStatus" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveStatus">Status</label>
                        <select name="status" id="editLeaveStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLeaveTypeForm() {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
        }

        function showLeaveTypeTable() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
        }

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showLeaveTypeForm();
        });

        function openEditLeaveTypeModal(id, cycleId, name, halfDayStatus, status) {
            document.getElementById('editLeaveTypeId').value = id;
            document.getElementById('editLeaveCycle').value = cycleId;
            document.getElementById('editLeaveTypeName').value = name;
            document.getElementById('editHalfDayStatus').value = halfDayStatus;
            document.getElementById('editLeaveStatus').value = status;

            const formAction = "{{ route('update_policy_type', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editLeaveTypeForm').action = formAction;

            document.getElementById('editLeaveTypeModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

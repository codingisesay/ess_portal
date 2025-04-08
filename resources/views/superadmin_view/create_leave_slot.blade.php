@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($leaveCycleDatas);
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
        <h1>Create Leave Policy Cycle</h1>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="but" onclick="showLeaveSlotForm()">Show Form</button>
            <button class="but" onclick="showLeaveSlotTable()">Show Table</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" style="display: none;">
            <form action="{{ route('insert_policy_slot') }}" method="POST" class="form-container">
                @csrf
                <div class="form-group">
                    <input type="text" id="category_name" name="cycle_name" class="form-control" required>
                    <label for="category_name">Cycle Name</label>
                </div>
                <div class="form-group">
                    <input type="datetime-local" id="category_name" name="start_date_time" class="form-control" required>
                    <label for="category_name">Start Date Time</label>
                </div>
                <div class="form-group">
                    <input type="datetime-local" id="category_name" name="end_date_time" class="form-control" required>
                    <label for="category_name">End Date Time</label>
                </div>
                <div class="form-group">
                    <input id="text" id="category_name" name="year_slot" class="form-control" required>
                    <label for="year">Input Year: (EX: 2025-26)</label>
                </div>
                <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Cycle</button>
            </form>
        </div>

        <!-- Table Section -->
        <div id="tableSection" style="display: none;">
            <h3>Leave Cycle</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Year</th>
                            <th>edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaveCycleDatas as $leaveCycleData)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leaveCycleData->name }}</td>
                                <td>{{ $leaveCycleData->start_date }}</td>
                                <td>{{ $leaveCycleData->end_date }}</td>
                                <td>{{ $leaveCycleData->year }}</td>
                                <td>
                                    <button class="edit-icon" onclick="openEditLeaveSlotModal({{ $leaveCycleData->id }}, '{{ $leaveCycleData->name }}', '{{ $leaveCycleData->start_date }}', '{{ $leaveCycleData->end_date }}', '{{ $leaveCycleData->year }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editLeaveSlotModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeaveSlotModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Policy Cycle</h2>
            </header>
            <div class="w3-container">
                <form id="editLeaveSlotForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="cycle_id" id="editLeaveSlotId">
                    <div class="popup-form-group">
                        <label for="editLeaveSlotName">Cycle Name</label>
                        <input type="text" name="cycle_name" id="editLeaveSlotName" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotStartDate">Start Date Time</label>
                        <input type="datetime-local" name="start_date_time" id="editLeaveSlotStartDate" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotEndDate">End Date Time</label>
                        <input type="datetime-local" name="end_date_time" id="editLeaveSlotEndDate" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotYear">Year</label>
                        <input type="text" name="year_slot" id="editLeaveSlotYear" required>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLeaveSlotForm() {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
        }

        function showLeaveSlotTable() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
        }

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showLeaveSlotForm();
        });

        function openEditLeaveSlotModal(id, name, startDate, endDate, year) {
            document.getElementById('editLeaveSlotId').value = id;
            document.getElementById('editLeaveSlotName').value = name;
            document.getElementById('editLeaveSlotStartDate').value = startDate;
            document.getElementById('editLeaveSlotEndDate').value = endDate;
            document.getElementById('editLeaveSlotYear').value = year;

            const formAction = "{{ route('update_policy_slot', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editLeaveSlotForm').action = formAction;

            document.getElementById('editLeaveSlotModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

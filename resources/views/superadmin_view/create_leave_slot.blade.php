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
                                <td><button class="edit-icon">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
    </script>
@endsection
</body>
</html>

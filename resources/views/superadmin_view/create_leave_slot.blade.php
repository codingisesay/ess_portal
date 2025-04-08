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
        <h3>Create Leave Policy Cycle</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button onclick="showLeaveSlotForm(this)">Show Form</button>
            <button onclick="showLeaveSlotTable(this)">Show Table</button>
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
        function showLeaveSlotForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showLeaveSlotTable(clickedElement) {
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
        showLeaveSlotForm(firstButton);
    });
 
    </script>
@endsection
</body>
</html>

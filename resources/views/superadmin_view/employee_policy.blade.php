@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($dataFromLeaveRestctions);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}"> 
</head>
<body>
    <div class="container">
        <h3>Employee Type Policy</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showEmployeePolicyTable(this)">Show Table</button>
            <button onclick="showEmployeePolicyForm(this)">Show Form</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" >
            <form action="{{route('insert_emp_restriction')}}" method="POST">
                @csrf
                <div  class="form-container row">
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="restriction_id" class="form-control" required>
                                <option value="" disabled selected></option>
                                @foreach ($dataFromLeaveRestctions as $dataFromLeaveRestction)
                                    <option value="{{ $dataFromLeaveRestction->leave_restriction_id }}">{{ $dataFromLeaveRestction->leave_type }}</option>
                                @endforeach
                            </select>
                            <label for="category_name">Leave Type</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <select id="category_id" name="emp_id" class="form-control" required>
                                <option value="" disabled selected></option>
                                @foreach ($empTypes as $empType)
                                    <option value="{{ $empType->id }}">{{ $empType->name }}</option>
                                @endforeach
                            </select>
                            <label for="category_name">Employee Type</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="category_name" name="leave_count" class="form-control" required>
                            <label for="category_name">Leave Count</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="form-group">
                            <input type="number" id="date" name="month_start" class="form-control" required max="30" oninput="validateInput(this)">
                            <label for="year">Month Start</label>
                        </div>
                    </div>
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Cycle</button>
                    </div>
                </div>
            </form>
        </div>
 
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $dataFroms,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                ['header' => 'Employee Type', 'accessor' => 'employee_type'],
                ['header' => 'Leave Count', 'accessor' => 'leave_count'],
                ['header' => 'Month Start', 'accessor' => 'month_start'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => false,
            'perPage' => 5
        ])
    </div>

    </div>

    <script>
        function showEmployeePolicyForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showEmployeePolicyTable(clickedElement) {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function validateInput(input) {
            if (input.value > 30) {
                input.value = 30;  // Set the value to 30 if it exceeds the limit
                alert('The value cannot exceed 30.');
            }
        }

        
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showEmployeePolicyTable(firstButton);
    });
    
    </script>
@endsection
</body>
</html>

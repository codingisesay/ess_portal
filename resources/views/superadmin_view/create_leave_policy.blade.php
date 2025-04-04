@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($results);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <title>Create Leave Policy</title>
    
</head>
<body>
    <div class="container">
        <h1>Create Leave Policy</h1>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="but" onclick="showLeavePolicyForm()">Show Form</button>
            <button class="but" onclick="showLeavePolicyTable()">Show Table</button>
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

            <form action="{{ route('insertPolicyConf') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <select id="category_id" name="leave_type_id" class="form-control" required>
                        <option value="" disabled selected></option>
                        @foreach ($results as $result)
                            <option value="{{ $result->leave_type_id }}">{{ $result->leave_type }}</option>
                        @endforeach
                    </select>
                    <label for="category_id">Select Leave Type</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="max_leave_count" class="form-control" required>
                    <label for="category_name">Max Leave</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="max_leave_at_time" class="form-control" required>
                    <label for="category_name">Max Leave At Time</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="min_leave_at_time" class="form-control" required step="0.5">
                    <label for="category_name">Min Leave At Time</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="is_carry_forward" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option> 
                    </select>
                    <label for="category_name">Is Carry Forward?</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="no_of_carry_forward" class="form-control" required>
                    <label for="category_name">No. Of Carry Forward</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="leave_encash" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option> 
                    </select>
                    <label for="category_name">Is Leave Encash?</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="leave_encash_count" class="form-control" required>
                    <label for="category_name">No. Of Leave Encash</label>
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
                            <th>Leave Type</th>
                            <th>Max Leave</th>
                            <th>Max Leave At Time</th>
                            <th>Min Leave At Time</th>
                            <th>Carry Forward</th>
                            <th>No. of Carry Forward</th>
                            <th>Encash</th>
                            <th>No. of Encash</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataFromLeaveRestctions as $dataFromLeaveRestction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dataFromLeaveRestction->leave_type }}</td>
                                <td>{{ $dataFromLeaveRestction->max_leave }}</td>
                                <td>{{ $dataFromLeaveRestction->max_leave_at_time }}</td>
                                <td>{{ $dataFromLeaveRestction->min_leave_at_time }}</td>
                                <td>{{ $dataFromLeaveRestction->carry_forward }}</td>
                                <td>{{ $dataFromLeaveRestction->no_carry_forward }}</td>
                                <td>{{ $dataFromLeaveRestction->leave_encash }}</td>
                                <td>{{ $dataFromLeaveRestction->no_leave_encash }}</td>
                                <td><button class="edit-icon">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showLeavePolicyForm() {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
        }

        function showLeavePolicyTable() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
        }

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showLeavePolicyForm();
        });
    </script>
@endsection
</body>
</html>

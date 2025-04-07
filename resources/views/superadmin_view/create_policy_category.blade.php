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
    <title>Create Policy Category</title>
    
</head>
<body>
    <div class="container">
        <h1>Create Policy Category</h1>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="but" onclick="showPolicyCategoryForm()">Show Form</button>
            <button class="but" onclick="showPolicyCategoryTable()">Show Table</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" style="display: none;">
            <form action="{{ route('save_policy_category') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <input type="text" id="category_name" name="category_name" class="form-control" required>
                    <label for="category_name">Category Name</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="status" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="category_id">Status</label>
                </div>
                <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Category</button>
            </form>
        </div>

        <!-- Table Section -->
        <div id="tableSection" style="display: none;">
            <h3>Policy Category</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->status}}</td>
                                <td><button class="edit-icon">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showPolicyCategoryForm() {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
        }

        function showPolicyCategoryTable() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
        }

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showPolicyCategoryForm();
        });
    </script>
@endsection
</body>
</html>

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
                                <td>
                                    <button class="edit-icon" onclick="openEditPolicyCategoryModal({{ $data->id }}, '{{ $data->name }}', '{{ $data->status }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editPolicyCategoryModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editPolicyCategoryModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Policy Category</h2>
            </header>
            <div class="w3-container">
                <form id="editPolicyCategoryForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="category_id" id="editPolicyCategoryId">
                    <div class="popup-form-group">
                        <label for="editPolicyCategoryName">Category Name</label>
                        <input type="text" name="category_name" id="editPolicyCategoryName" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editPolicyCategoryStatus">Status</label>
                        <select name="status" id="editPolicyCategoryStatus" required>
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

        function openEditPolicyCategoryModal(id, name, status) {
            document.getElementById('editPolicyCategoryId').value = id;
            document.getElementById('editPolicyCategoryName').value = name;
            document.getElementById('editPolicyCategoryStatus').value = status;

            // Dynamically set the form action with the correct ID
            const formAction = "{{ route('update_policy_category', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editPolicyCategoryForm').action = formAction;

            document.getElementById('editPolicyCategoryModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

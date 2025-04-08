@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
error_reporting(0);
$id = Auth::guard('superadmin')->user()->id;
// dd($categories);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
    <title>Create HR Policy</title>
    
</head>
<body>
    <div class="container">
        <h1>Create HR Policy</h1>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button class="but" onclick="showHRPolicyForm()">Show Form</button>
            <button class="but" onclick="showHRPolicyTable()">Show Table</button>
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

            <form action="{{ route('save_hr_policy') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <input type="text" id="policy_title" name="policy_title" class="form-control" required>
                    <label for="policy_title">Policy Title</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="" disabled selected></option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="category_id">Select Category</label>
                </div>
                <div class="form-group">
                    <input type="text" id="policy_content" name="policy_content" class="form-control" required>
                    <label for="policy_content">Policy Content</label>
                </div>
                <div class="form-group">
                    <input type="file" id="document" name="document" class="form-control">
                    <label for="document">Upload Document</label>
                </div>
                <div class="form-group">
                    <input type="file" id="icon" name="icon" class="form-control">
                    <label for="icon">Upload Icon</label>
                </div>
                <div class="form-group">
                    <input type="file" id="content_image" name="content_image" class="form-control">
                    <label for="content_image">Upload Content Image</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="status" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="category_id">Status</label>
                </div>
                <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Policy</button>
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
                            <th>TITLE</th>
                            <th>CATEGORY</th>
                            <!-- <th>CONTENT</th> -->
                            <th>Status</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->policy_title }}</td>
                                <td>{{ $data->policy_categorie_id }}</td>
                                <!-- <td>{{ $data->policy_content }}</td> -->
                                <td>{{ $data->status }}</td>
                                <td>
                                    <button class="edit-icon" onclick="openEditHRPolicyModal({{ $data->id }}, '{{ $data->policy_title }}', '{{ $data->policy_categorie_id }}', '{{ $data->status }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editHRPolicyModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editHRPolicyModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit HR Policy</h2>
            </header>
            <div class="w3-container">
            <!--use id to save data as post method -->
                 <form id="editHRPolicyForm" method="POST">  
                    @csrf
                    @method('POST')
                    <input type="hidden" name="policy_id" id="editHRPolicyId">
                    <div class="popup-form-group">
                        <label for="editHRPolicyTitle">Policy Title</label>
                        <input type="text" name="policy_title" id="editHRPolicyTitle" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editHRPolicyCategory">Select Category</label>
                        <select name="category_id" id="editHRPolicyCategory" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editHRPolicyStatus">Status</label>
                        <select name="status" id="editHRPolicyStatus" required>
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
        function showHRPolicyForm() {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
        }

        function showHRPolicyTable() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
        }

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showHRPolicyForm();
        });

        function openEditHRPolicyModal(id, title, categoryId, status) {
            document.getElementById('editHRPolicyId').value = id;
            document.getElementById('editHRPolicyTitle').value = title;
            document.getElementById('editHRPolicyCategory').value = categoryId;
            document.getElementById('editHRPolicyStatus').value = status;

            const formAction = "{{ route('update_hr_policy', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editHRPolicyForm').action = formAction;

            document.getElementById('editHRPolicyModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

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
        <h3>Create Policy Category</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showPolicyCategoryTable(this)">Show Table</button>
            <button onclick="showPolicyCategoryForm(this)">Show Form</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" >
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
                <button type="submit" class="create-btn"  >Save Category</button>
            </form>
        </div>

        <!-- Table Section -->
        <div id="tableSection" > 
            <!-- <div class="table-container">
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
                                    <button class="edit-icon" onclick="openEditModal({{ $data->id }}, '{{ $data->name }}', '{{ $data->status }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> -->
        </div>

        
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $datas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Ststus', 'accessor' => 'status'],
            ],
            'editModalId' => 'editPolicyCategoryModal',
            'hasActions' => true,
            'perPage' => 5
        ])
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
        function showPolicyCategoryForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showPolicyCategoryTable(clickedElement) {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }
 
    // Ensure the first button (Show table) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showPolicyCategoryTable(firstButton);
    });
      
        function openEditModal(id, item) {
            document.getElementById('editPolicyCategoryId').value = id;
            document.getElementById('editPolicyCategoryName').value = item.name;
            document.getElementById('editPolicyCategoryStatus').value = item.status; 
            // Dynamically set the form action with the correct ID
            const formAction = "{{ route('update_policy_category', ['id' => ':id']) }}".replace(':id', item.id);
            document.getElementById('editPolicyCategoryForm').action = formAction;

            document.getElementById('editPolicyCategoryModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

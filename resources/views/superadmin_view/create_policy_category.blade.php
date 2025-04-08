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

         
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showPolicyCategoryTable(firstButton);
    });
      
    </script>
@endsection
</body>
</html>

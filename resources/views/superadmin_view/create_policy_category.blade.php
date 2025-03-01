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
        @if(session('success'))
        <div class="alert custom-alert-success">
            <strong>{{ session('success') }}</strong> 
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            
        </div>
    @endif
    
    @if(session('error'))
    <div class="alert custom-alert-error">
        <strong> {{ session('error') }}</strong>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif

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
@endsection
</body>
</html>

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
    <title>Create HR Policy</title>
    
</head>
<body>
    <div class="container">
        <h1>Create HR Policy</h1>
        {{-- @if(session('success'))
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
    @endif --}}

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
                <input type="text" id="policy_content" name="policy_content" class="form-control" required></textarea>
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

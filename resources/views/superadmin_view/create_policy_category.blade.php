@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<?php 
$id = Auth::guard('superadmin')->user()->id;
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
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('save_policy_category') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <input type="text" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Category Name</label>
            </div>
            <button type="submit" class="create-btn">Save Category</button>
        </form>
    </div>
@endsection
</body>
</html>

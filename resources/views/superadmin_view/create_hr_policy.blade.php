@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->

<?php 
$id = Auth::guard('superadmin')->user()->id;
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('save_hr_policy') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <input type="text" id="policy_title" name="policy_title" class="form-control" required>
                <label for="policy_title">Policy Title</label>
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
            <button type="submit" class="create-btn">Save Policy</button>
        </form>
    </div>
@endsection
</body>
</html>

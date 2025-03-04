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
    <title>Create Leave Policy</title>
    
</head>
<body>
    <div class="container">
        <h1>Create Leave Policy</h1>
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

    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif

        <form action="" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option>General Leave Policy</option>
                </select>
                <label for="category_id">Select Leave Type</label>
            </div>

            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Max Leave</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Max Leave At Time</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Min Leave At Time</label>
            </div>
            {{-- <div class="form-group">
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value=""></option>
                    <option>Yes</option>
                    <option>No</option> 
                </select>
                <label for="category_name">Is Leave Laps?</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">No. Of Leave Laps</label>
            </div> --}}

            <div class="form-group">
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value=""></option>
                    <option>Yes</option>
                    <option>No</option> 
                </select>
                <label for="category_name">Is Carry Forward?</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">No. Of Carry Forward</label>
            </div>

            <div class="form-group">
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value=""></option>
                    <option>Yes</option>
                    <option>No</option> 
                </select>
                <label for="category_name">Is Leave Encash?</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">No. Of Leave Encash</label>
            </div>
            {{-- <div class="form-group">
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value=""></option>
                    <option>Active</option>
                    <option>Inactive</option>
                    
                </select>
                <label for="category_id">Status</label>
            </div> --}}
          
            <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Type</button>
        </form>

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
              

                    <tr>
                        <td>1</td>
                        <td>General Leave Policy</td>
                        <td>24</td>
                        <td>2</td>
                        <td>0.5</td>
                        <td>Yes</td>
                        <td>8</td>
                        <td>Yes</td>
                        <td>8</td>
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                        
                 
                        
                    
                </tbody>
            </table>
        </div>

    </div>
@endsection
</body>
</html>

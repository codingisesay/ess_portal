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
        <h1>Create Leave Type</h1>
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

        <form action="{{ route('insert_policy_type') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <select id="category_id" name="cycle_slot_id" class="form-control" required>
                    <option value="" disabled selected></option>
                    @foreach ($leaveCycleDatas as $leaveCycleData)
                    <option value="{{$leaveCycleData->id}}">{{ $leaveCycleData->name }}</option>
                    @endforeach
                  
                    
                </select>
                <label for="category_id">Select Cycle</label>
            </div>
            <div class="form-group">
                <input type="text" id="category_name" name="leave_category" class="form-control" required>
                <label for="category_name">Leave Type Name</label>
            </div>
            <div class="form-group">
                <select id="category_id" name="half_day_status" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    
                </select>
                <label for="category_name">Half Day Applicable?</label>
            </div>
            <div class="form-group">
                <select id="category_id" name="status" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    
                </select>
                <label for="category_id">Status</label>
            </div>
            {{-- <div class="form-group"> --}}
                {{-- <input type="year" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Year</label> --}}

                
                {{-- <select id="year" name="year" id="category_name" name="category_name" class="form-control" required></select>
                <label for="year">Select Year:</label>
            </div> --}}
            {{-- <div class="form-group">
                <select id="category_id" name="status" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
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
                        <th>Cycle Name</th>
                        <th>Leave Type</th>
                        <th>Half Day</th>
                        <th>Status</th>
                        <th>Edit</th>
                      
                    </tr>
                </thead>
                <tbody>
              
             @foreach ($results as $result)
                 
             
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->leave_cycle_name }}</td>
                        <td>{{ $result->leave_type }}</td>
                        <td>{{ $result->leave_half_status }}</td>
                        <td>{{ $result->leave_status }}</td>
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

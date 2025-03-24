@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($dataFromLeaveRestctions);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <title>Create Policy Category</title>
    
</head>
<body>
    <div class="container">
        <h1>Employee Type Policy</h1>
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

        <form action="{{route('insert_emp_restriction')}}" method="POST" class="form-container">
            @csrf
            <div class="form-group">
                <select id="category_id" name="restriction_id" class="form-control" required>
                    <option value="" disabled selected></option>
                    @foreach ($dataFromLeaveRestctions as $dataFromLeaveRestction)

                    <option value="{{ $dataFromLeaveRestction->leave_restriction_id }}">{{ $dataFromLeaveRestction->leave_type }}</option>
               
                        
                    @endforeach
                    
                </select>
                <label for="category_name">Leave Type</label>
            </div>
            <div class="form-group">
                <select id="category_id" name="emp_id" class="form-control" required>
                    <option value="" disabled selected></option>
                    @foreach ($empTypes as $empType)

                    <option value="{{ $empType->id }}">{{ $empType->name }}</option>
                        
                    @endforeach
                   
                </select>
                <label for="category_name">Employee Type</label>
            </div>
            <div class="form-group">
                <input type="number" id="category_name" name="leave_count" class="form-control" required>
                <label for="category_name">Leave Count</label>
            </div>
            <div class="form-group">
                {{-- <input type="year" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Year</label> --}}

                
                <input type="number" id="date" name="month_start" id="category_name" name="category_name" class="form-control" required max="30" oninput="validateInput(this)" >
                <label for="year">Month Start</label>
            </div>
            {{-- <div class="form-group">
                <select id="category_id" name="status" class="form-control" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <label for="category_id">Status</label>
            </div> --}}
            <button type="submit" class="create-btn" style="position: relative; bottom:8px;">Save Cycle</button>
        </form>

        <h3>Leave Cycle</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        
                        <th>Id</th>
                        <th>Leave Type</th>
                        <th>Employee Type</th>
                        <th>Leave Count</th>
                        <th>Month Start</th>
                        <th>edit</th>
                    </tr>
                </thead>
                <tbody>
              
@foreach ($dataFroms as $dataFrom)

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $dataFrom->leave_type }} </td>
    <td>{{ $dataFrom->employee_type }}</td>
    <td>{{ $dataFrom->leave_count }}</td>
    <td>{{ $dataFrom->month_start }}</td>
    <td><button class="edit-icon">Edit</button></td>
</tr>
    
@endforeach
                   
                        
                 
                        
                    
                </tbody>
            </table>
        </div>

    </div>
    <script>
        const select = document.getElementById("year");
        const startYear = 2025; // Starting year
        const endYear = 2050;   // Ending year
      
        for (let year = startYear; year <= endYear; year++) {
          const option = document.createElement("option");
          option.value = year;
          option.textContent = year;
          select.appendChild(option);
        }

        function validateInput(input) {
    if (input.value > 30) {
        input.value = 30;  // Set the value to 30 if it exceeds the limit
        alert('The value cannot exceed 30.');
    }
}

      </script>
@endsection
</body>
</html>

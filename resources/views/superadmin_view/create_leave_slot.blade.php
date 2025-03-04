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
        <h1>Create Leave Policy Cycle</h1>
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
                <input type="text" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Cycle Name</label>
            </div>
            <div class="form-group">
                <input type="datetime-local" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Start Date Time</label>
            </div>
            <div class="form-group">
                <input type="datetime-local" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">End Date Time</label>
            </div>
            <div class="form-group">
                {{-- <input type="year" id="category_name" name="category_name" class="form-control" required>
                <label for="category_name">Year</label> --}}

                
                <select id="year" name="year" id="category_name" name="category_name" class="form-control" required></select>
                <label for="year">Select Year:</label>
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
                        <th>Name</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Year</th>
                        <th>edit</th>
                    </tr>
                </thead>
                <tbody>
              

                    <tr>
                        <td>1</td>
                        <td>1-April-2025 to 31-March-2026 </td>
                        <td>1-April-2025</td>
                        <td>31-March-2026</td>
                        <td>2025-26</td>
                        <td><button class="edit-icon">Edit</button></td>
                    </tr>
                        
                 
                        
                    
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
      </script>
@endsection
</body>
</html>

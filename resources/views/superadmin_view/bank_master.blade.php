@extends('superadmin_view/superadmin_layout')
@section('content')

<html>
<head>
<title>Bank Master</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<style>
    /* Container for sort buttons - keeps them together */
    .sort-buttons {
        display: flex;
        gap: 4px;
        margin-left: 8px;
    }
    /* Individual sort button styling */
    .sort-button {
        background: #f0f0f0;  /* Light gray background */
        border: 1px solid #ddd;  /* Light border */
        border-radius: 3px;  /* Rounded corners */
        padding: 2px 6px;  /* Internal spacing */
        cursor: pointer;  /* Pointer cursor on hover */
        transition: all 0.2s;  /* Smooth transitions */
        font-size: 14px;  /* Button text size */
        color: #000;  /* Black text/arrows */
    }
    /* Hover state for sort buttons */
    .sort-button:hover {
        background: #e0e0e0;  /* Slightly darker on hover */
    }
    
    /* Active sort button state */
    .sort-button.active {
        background: #f0f0f0;  /* Same as default */
        color: #000;  /* Keep text black */
        border-color: #007bff;  /* Blue border for active state */
    }
    
    /* Ensure sort icons are always black */
    .sort-button i {
        color: #000;
    }
    .sort-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        color: #666;
        text-decoration: none;
        transition: all 0.2s;
    }
    .sort-icon:hover {
        color: #000;
        transform: scale(1.1);
    }
    th {
        position: relative;
        cursor: pointer;
        white-space: nowrap;
        padding: 12px 8px !important;
    }
    .fa-sort {
        opacity: 0.5;
    }
    .fa-sort-up, .fa-sort-down {
        opacity: 1;
    }
    .sort-container {
        display: flex;
        align-items: center;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <h3>Bank Master</h3>

    <!-- Toggle -->
    <div class="toggle-buttons">
        <button onclick="showTable(this)" class="active">Show Table</button>
        <button onclick="showForm(this)">Show Form</button>
    </div>

    <!-- Bank Form (hidden by default) -->
    <div id="formSection" style="display:none;">
        <form action="{{ route('store_bank') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-4 mb-2">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Bank Name</label>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="form-group">
                        <select name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
                <div class="col-4">
                    <button class="create-btn" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bank Table (shown by default) -->
    <div class="table-container" id="tableSection">
        <table class="table border">
            <thead>
                <tr>
                    <th>
                        <div class="sort-container">
                            ID
                            <div class="sort-buttons">
                                <a href="?sort=id&order=asc" class="sort-button {{ $sort === 'id' && $order === 'asc' ? 'active' : '' }}" title="Sort ascending">
                                    <i class="fa fa-sort-up"></i>
                                </a>
                                <a href="?sort=id&order=desc" class="sort-button {{ $sort === 'id' && $order === 'desc' ? 'active' : '' }}" title="Sort descending">
                                    <i class="fa fa-sort-down"></i>
                                </a>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="sort-container">
                            Bank Name
                            <div class="sort-buttons">
                                <a href="?sort=name&order=asc" class="sort-button {{ $sort === 'name' && $order === 'asc' ? 'active' : '' }}" title="Sort A-Z">
                                    <i class="fa fa-sort-up"></i>
                                </a>
                                <a href="?sort=name&order=desc" class="sort-button {{ $sort === 'name' && $order === 'desc' ? 'active' : '' }}" title="Sort Z-A">
                                    <i class="fa fa-sort-down"></i>
                                </a>
                            </div>
                        </div>
                    </th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banks as $bank)
                    <tr>
                        <td>{{ $bank->id }}</td>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->status }}</td>
                        <td>
                            <!-- Edit -->
                            <form action="{{ route('update_bank', $bank->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="text" name="name" value="{{ $bank->name }}" required>
                                <select name="status">
                                    <option value="Active" {{ $bank->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $bank->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('delete_bank', $bank->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this bank?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function showForm(btn) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';

        let siblings = btn.parentElement.children;
        for (let s of siblings) s.classList.remove('active');
        btn.classList.add('active');
    }
    function showTable(btn) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';

        let siblings = btn.parentElement.children;
        for (let s of siblings) s.classList.remove('active');
        btn.classList.add('active');
    }
</script>

</body>
</html>
@endsection

<!-- resources/views/attendance/import.blade.php -->
 @extends('superadmin_view/superadmin_layout')  

@section('content')
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<!-- Add any other CSS files used in create_user.blade.php -->

<div class="container">
    <h3>Upload Attendance Sheet</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.import') }}" method="POST" enctype="multipart/form-data" class="form-container row">
        @csrf
        <div class="col-4 mb-2">
            <div class="form-group">
                <label>Select Attendance File (.xls/.xlsx/.csv)</label>
                <input type="file" name="attendance_file" class="form-control" required>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="create-btn">Upload & Import</button>
        </div>
    </form>
</div>
@endsection

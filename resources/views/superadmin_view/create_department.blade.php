<!-- [file name: create_department.blade.php] -->
@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/pagination.css') }}">

<div class="container">
    <h3>Create Department For Your Organisation</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button class="active" onclick="showDepartmentTable(this)">Show Table</button>
        <button onclick="showDepartmentForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" style="display: none;">
        <form method="POST" action="{{ route('insert_department') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{ Auth::guard('superadmin')->user()->id }}">
                    <input type="text" name="department_name" required>
                    <label>Department Name</label>
                </div>
                <div class="form-group">
                    <button class="create-btn" type="submit">Create Department</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $departments,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
            ],
            'editModalId' => 'editDepartmentModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editDepartmentModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Department</h2>
        </header>
        <div class="w3-container">
            <form id="editDepartmentForm" action="{{ route('update_department') }}" method="POST">
                @csrf
                <input type="hidden" name="department_id" id="editDepartmentId">
                <div class="popup-form-group">
                    <label for="editDepartmentName">Department Name</label>
                    <input type="text" name="department_name" id="editDepartmentName" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showDepartmentForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none'; 
        updateActiveButton(clickedElement);
    }

    function showDepartmentTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block'; 
        updateActiveButton(clickedElement);
    }

    function updateActiveButton(clickedElement) {
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function openEditModal(modalId, item) {
        if (modalId === 'editDepartmentModal') {
            document.getElementById('editDepartmentId').value = item.id;
            document.getElementById('editDepartmentName').value = item.name;
            document.getElementById(modalId).style.display = 'block';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        showDepartmentTable(document.querySelector('.toggle-buttons button:first-child'));
    });
</script>
@endsection
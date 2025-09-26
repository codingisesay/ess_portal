@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">

<div class="container">
    <h3>Organization Settings</h3>
    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button onclick="showOrgSettingsTable(this)">Show Table</button>
        <button onclick="showOrgSettingsForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection">
        <form action="{{ url('/org-settings') }}" method="POST">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" required maxlength="100">
                        <label for="name">Organization Name</label>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                        <label for="start_date">Start Date</label>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                        <label for="end_date">End Date</label>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="form-group">
                        <input type="number" name="created_by" id="created_by" class="form-control" required>
                        <label for="created_by">Created By (User ID)</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="create-btn" type="submit">Save Settings</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $orgSettings ?? [],
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Start Date', 'accessor' => 'start_date'],
                ['header' => 'End Date', 'accessor' => 'end_date'],
                ['header' => 'Created By', 'accessor' => 'created_by'],
            ],
            'editModalId' => 'editOrgSettingsModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>

    <!-- Edit Modal (structure only, fill as needed) -->
    <div id="editOrgSettingsModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal">
                <span onclick="document.getElementById('editOrgSettingsModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Organization Setting</h2>
            </header>
            <div class="w3-container">
                <!-- Edit form goes here -->
            </div>
        </div>
    </div>
</div>

<script>
    function showOrgSettingsForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }

    function showOrgSettingsTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        }
        clickedElement.classList.add('active');
    }

    // Show table by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showOrgSettingsTable(firstButton);
    });
</script>
@endsection
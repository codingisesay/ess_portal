@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

<!DOCTYPE html>
<html>
<head>
<title>Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<div class="container">
    <h3>Creates Salary Templates</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
    <button onclick="showSalaryTemplateTable(this)">Show Table</button>
        <button onclick="showSalaryTemplateForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" >
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_salary_template') }}">
            @csrf
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" name="cycle_id" required>
                        <label>Cycle</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="month_start_date" required>
                        <label>Month Start Date</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="month_end_date" required>
                        <label>Month End Date</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="status" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
              
                <div class="col-12">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- Table Section -->
    {{-- <div id="tableSection">
        @include('partials.data_table', [
            'items' => $template_datas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Template Name', 'accessor' => 'name'],
                ['header' => 'Min CTC', 'accessor' => 'min_ctc'],
                ['header' => 'Max CTC', 'accessor' => 'max_ctc'],
                ['header' => 'Status', 'accessor' => 'status'],
            ], 
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div> --}}


</div>

<div id="editSalaryTemplateModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryTemplateModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Salary Template</h2>
        </header>
        <div class="w3-container">
            <form id="editSalaryTemplateForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="template_id" id="editSalaryTemplateId">
                <div class="popup-form-group">
                    <input type="text" name="template_name" id="editSalaryTemplateName" required>
                    <label for="editSalaryTemplateName">Name</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="min_ctc" id="editSalaryTemplateMinCTC" required>
                    <label for="editSalaryTemplateMinCTC">Min CTC</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="max_ctc" id="editSalaryTemplateMaxCTC" required>
                    <label for="editSalaryTemplateMaxCTC">Max CTC</label>
                </div>
                <div class="popup-form-group">
                    <select name="status" id="editSalaryTemplateStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editSalaryTemplateStatus">Status</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showSalaryTemplateForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
    }

    function showSalaryTemplateTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
    }
 
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showSalaryTemplateTable(firstButton);
    });
    

    function openEditModal(id, templatedata) {
        if (!id) {
            alert('Invalid template data. Please try again.');
            return;
        } 
        document.getElementById('editSalaryTemplateId').value = templatedata.id;
        document.getElementById('editSalaryTemplateName').value = templatedata.name || '';
        document.getElementById('editSalaryTemplateMinCTC').value =templatedata.min_ctc || '';
        document.getElementById('editSalaryTemplateMaxCTC').value = templatedata.max_ctc || '';
        document.getElementById('editSalaryTemplateStatus').value = templatedata.status || '';

        const formAction = "{{ route('update_salary_template', ['id' => ':id']) }}".replace(':id', templatedata.id);
        document.getElementById('editSalaryTemplateForm').action = formAction;

        document.getElementById('editSalaryTemplateModal').style.display = 'block';
    }
</script>

@endsection


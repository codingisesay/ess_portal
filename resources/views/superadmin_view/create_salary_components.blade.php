@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($templates);
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
    <button onclick="showSalaryComponentTable(this)">Show Table</button>
        <button onclick="showSalaryComponentForm(this)">Show Form</button>
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

        <form method="POST" action="{{ route('insert_salary_Components') }}">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <select name="template_id" required>
                        <option value="" disabled selected></option>
                        @foreach ($templates as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <label>Salary Template</label>
                </div>
                <div class="form-group">
                    <input type="component_name" name="component_name" required>
                    <label>Component Name</label>
                </div>
                <div class="form-group">
                    <select name="component_type" required>
                        <option value="" disabled selected></option>
                        <option value="Earning">Earning</option>
                        <option value="Deduction">Deduction</option>
                    </select>
                    <label>Type</label>
                </div>
                <div class="form-group">
                    <select name="calculation_type" required>
                        <option value="" disabled selected></option>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </select>
                    <label>Calculation Type</label>
                </div>
                <div class="form-group">
                    <input type="number" name="value" required>
                    <label>Value</label>
                </div>
                <div class="form-group">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" >
 
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Template Name</th>
                        <th>Component Name</th>
                        <th>Type</th>
                        <th>Calculation Type</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($componentdata as $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $items->template_name }}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->type }}</td>
                            <td>{{ $items->calculation_type }}</td>
                            <td>{{ $items->value }}</td>
                            <td>
                                <button class="edit-icon" onclick="openEditSalaryComponentModal({{ $items->id }}, '{{ $items->template_name }}', '{{ $items->name }}', '{{ $items->type }}', '{{ $items->calculation_type }}', '{{ $items->value }}')">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editSalaryComponentModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editSalaryComponentModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Salary Component</h2>
        </header>
        <div class="w3-container">
            <form id="editSalaryComponentForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="component_id" id="editSalaryComponentId">
                <div class="popup-form-group">
                    <label for="editSalaryComponentTemplate">Salary Template</label>
                    <select name="template_id" id="editSalaryComponentTemplate" required>
                        @foreach ($templates as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="popup-form-group">
                    <label for="editSalaryComponentName">Component Name</label>
                    <input type="text" name="component_name" id="editSalaryComponentName" required>
                </div>
                <div class="popup-form-group">
                    <label for="editSalaryComponentType">Type</label>
                    <select name="component_type" id="editSalaryComponentType" required>
                        <option value="Earning">Earning</option>
                        <option value="Deduction">Deduction</option>
                    </select>
                </div>
                <div class="popup-form-group">
                    <label for="editSalaryComponentCalculationType">Calculation Type</label>
                    <select name="calculation_type" id="editSalaryComponentCalculationType" required>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </select>
                </div>
                <div class="popup-form-group">
                    <label for="editSalaryComponentValue">Value</label>
                    <input type="number" name="value" id="editSalaryComponentValue" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showSalaryComponentForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    function showSalaryComponentTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) {
            sibling.classList.remove('active');
        } 
        clickedElement.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showSalaryComponentTable(firstButton);
    });

    function openEditSalaryComponentModal(id, templateName, componentName, type, calculationType, value) {
        document.getElementById('editSalaryComponentId').value = id;
        document.getElementById('editSalaryComponentTemplate').value = templateName;
        document.getElementById('editSalaryComponentName').value = componentName;
        document.getElementById('editSalaryComponentType').value = type;
        document.getElementById('editSalaryComponentCalculationType').value = calculationType;
        document.getElementById('editSalaryComponentValue').value = value;

        const formAction = "{{ route('update_salary_component', ['id' => ':id']) }}".replace(':id', id);
        document.getElementById('editSalaryComponentForm').action = formAction;

        document.getElementById('editSalaryComponentModal').style.display = 'block';
    }
</script>

@endsection


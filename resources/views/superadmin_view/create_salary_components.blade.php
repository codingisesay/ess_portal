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
            <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="template_id" required>
                            <option value="" disabled selected></option>
                            @foreach ($templates as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label>Salary Template</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="component_id" required>
                            <option value="" disabled selected></option>
                            @foreach ($orgComp as $OC)
                                <option value="{{ $OC->id }}">{{ $OC->name }}</option>
                            @endforeach
                        </select>
                        <label>Component Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="component_type" required>
                            <option value="" disabled selected></option>
                            <option value="Earning">Earning</option>
                            <option value="Deduction">Deduction</option>
                        </select>
                        <label>Type</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="calculation_type" required>
                            <option value="" disabled selected></option>
                            <option value="Percentage">Percentage</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Calculative">Calculative</option>
                            <option value="Others">Others</option>
                        </select>
                        <label>Calculation Type</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="number" name="value">
                        <label>Value</label>
                    </div>
                </div>
           
                <div class="col-12">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $componentdata,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Template Name', 'accessor' => 'template_name'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Type', 'accessor' => 'type'],
                ['header' => 'Calculation Type', 'accessor' => 'calculation_type'],
                ['header' => 'Value', 'accessor' => 'value'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
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
                    <select name="template_id" id="editSalaryComponentTemplate" required>
                        @foreach ($templates as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <label for="editSalaryComponentTemplate">Salary Template</label>
                </div>
                <div class="popup-form-group">
                    <!-- <input type="text" name="component_name" id="editSalaryComponentName" required> -->
                    <select name="component_name" id="editSalaryComponentName" required>
                        @foreach ($orgComp as $comp)
                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                        @endforeach
                    </select>
                    <label for="editSalaryComponentName">Component Name</label>
                </div>
                <div class="popup-form-group">
                    <select name="component_type" id="editSalaryComponentType" required>
                        <option value="Earning">Earning</option>
                        <option value="Deduction">Deduction</option>
                    </select>
                    <label for="editSalaryComponentType">Type</label>
                </div>
                <div class="popup-form-group">
                    <select name="calculation_type" id="editSalaryComponentCalculationType" required>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </select>
                    <label for="editSalaryComponentCalculationType">Calculation Type</label>
                </div>
                <div class="popup-form-group">
                    <input type="number" name="value" id="editSalaryComponentValue" required>
                    <label for="editSalaryComponentValue">Value</label>
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

    function openEditModal(id, datas) {
        console.log(datas);
        document.getElementById('editSalaryComponentId').value = datas.id;
        document.getElementById('editSalaryComponentTemplate').value = datas.salary_template_id;
        document.getElementById('editSalaryComponentName').value = datas.org_comp_id;
        document.getElementById('editSalaryComponentType').value = datas.type;
        document.getElementById('editSalaryComponentCalculationType').value = datas.calculation_type;
        document.getElementById('editSalaryComponentValue').value = datas.value;

        const formAction = "{{ route('update_salary_component', ['id' => ':id']) }}".replace(':id', datas.id);
        document.getElementById('editSalaryComponentForm').action = formAction;

        document.getElementById('editSalaryComponentModal').style.display = 'block';
    }
</script>

@endsection


@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
error_reporting(0);
$id = Auth::guard('superadmin')->user()->id;
// dd($categories);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
    <title>Create HR Policy</title>
    
</head>
<body>
    <div class="container">
        <h3>Create Reimbursement Restriction</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showHRPolicyTable(this)">Show Table</button>
            <button onclick="showHRPolicyForm(this)">Show Form</button>
        </div>

        <!-- Form Section -->
        <div id="formSection">
            
        <form  >
                @csrf
                <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="organisation_reimbursement_type_id" name="organisation_reimbursement_type_id" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Travel</option>
                            <option value="Inactive">Food</option>
                        </select>
                        <label for="category_id">Reimbusrtment Type</label>
                    </div> 
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="category_name" class="form-control" required>
                        <label for="category_name">Maximum Amount</label>
                    </div>
                </div> 
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="category_id" name="status" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Yes</option>
                            <option value="Inactive">No</option>
                        </select>
                        <label for="category_id">Bill Required</label>
                    </div> 
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="category_id" name="status" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Yes</option>
                            <option value="Inactive">No</option>
                        </select>
                        <label for="category_id">Tax Required</label>
                    </div> 
                </div>

                <div class="col-12"> <button type="submit" class="create-btn"  >Save Category</button></div>
                </div>
            </form>
        </div>

     
    <!-- Table Section -->
    <div id="tableSection">
        <!-- change table and column name for table apperance -->
    @include('partials.data_table', [
            'items' => $datafortaxes,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Reimbursement Type', 'accessor' => 'organisation_reimbursement_type_id'],
                ['header' => 'maximum Amount', 'accessor' => 'org_tax_regime_years_name'],
                ['header' => 'Bill Required', 'accessor' => 'bill_required'],
                ['header' => 'Tax Required', 'accessor' => 'tax_applicable'], 
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div> 
    </div>
 
    <script>
        function showHRPolicyForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showHRPolicyTable(clickedElement) {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        // Ensure the form is visible by default on page load
        
    // Ensure the first button (Show Form) is active by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showHRPolicyTable(firstButton);
    });
      
 
    </script>
@endsection
</body>
</html>

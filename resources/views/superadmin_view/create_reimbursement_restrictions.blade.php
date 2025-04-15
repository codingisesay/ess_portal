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
            
        <form action="{{ route('insert_reimbursement_validation') }}" method="POST">
                @csrf
                <div class="form-container row">
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="organisation_reimbursement_type_id" name="reimbursement_type_id" class="form-control" required>
                            <option value="" disabled selected></option>
                            @foreach ($reim_type as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option> 
                            @endforeach
                            
                           
                        </select>
                        <label for="category_id">Reimbusrtment Type</label>
                    </div> 
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="max_amount" class="form-control" required>
                        <label for="category_name">Maximum Amount</label>
                    </div>
                </div> 
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="category_id" name="bill_required" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <label for="category_id">Bill Required</label>
                    </div> 
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group ">
                        <select id="category_id" name="tax_required" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
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
            'items' => $table_data,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Reimbursement Type', 'accessor' => 'reim_type'],
                ['header' => 'maximum Amount', 'accessor' => 'max_amount'],
                ['header' => 'Bill Required', 'accessor' => 'bill_required'],
                ['header' => 'Tax Required', 'accessor' => 'tax_applicable'], 
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div> 
    </div>

    <!-- Edit Modal -->
    <div id="editReimbursementModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal">
                <span onclick="document.getElementById('editReimbursementModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Reimbursement Restriction</h2>
            </header>
            <div class="w3-container">
                <form id="editReimbursementForm" action="{{ route('update_reimbursement_validation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="editReimbursementId">
                    <div class="popup-form-group">
                        <label for="editReimbursementType">Reimbursement Type</label>
                        <input type="text" name="reimbursement_type" id="editReimbursementType" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editMaxAmount">Maximum Amount</label>
                        <input type="text" name="max_amount" id="editMaxAmount" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editBillRequired">Bill Required</label>
                        <select name="bill_required" id="editBillRequired" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editTaxRequired">Tax Required</label>
                        <select name="tax_required" id="editTaxRequired" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
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

        function openEditModal(userdata) {
            document.getElementById('editReimbursementId').value = userdata.id;
            document.getElementById('editReimbursementType').value = userdata.reim_type;
            document.getElementById('editMaxAmount').value = userdata.max_amount;
            document.getElementById('editBillRequired').value = userdata.bill_required;
            document.getElementById('editTaxRequired').value = userdata.tax_applicable;
            document.getElementById('editReimbursementModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

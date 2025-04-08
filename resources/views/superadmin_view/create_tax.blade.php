@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">

<?php 
$id = Auth::guard('superadmin')->user()->id;
?>

<!DOCTYPE html>
<html>
<head>
 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<div class="container">
    <h3>Create Salary Taxes   </h3>

 <!-- Toggle Buttons -->
 <div class="toggle-buttons">
 <button onclick="showUserTable(this)">Show Table</button>
        <button onclick="showUserForm(this)">Show Form</button>
    </div>
    @if($errors->any())
    <div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
    <li class="text-danger">{{ $error }}</li>
    
@endforeach
</ul>
    </div>
@endif

    <!-- Form Section -->
    <div id="formSection" > 
    <form method="POST" action="{{ route('insert_taxes') }}">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <select name="tax_cycle_type" required>
                    <option value="" disabled selected></option>
                    @foreach ($taxregim as $tax)
                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                    @endforeach
                </select>
             
                <label>Tax Regime</label>
            </div>
            <div class="form-group">
                <select name="tax_type" required>
                    <option value="" disabled selected></option>
                    <option value="Income Tax">Income Tax</option>
                </select>
                <label>Tax Type</label>
            </div>
            <div class="form-group">
                <input type="number" name="min_income" required>
                <label>Min Income</label>
            </div>
            <div class="form-group">
                <input type="number" name="max_income" required>
                <label>Max Income</label>
            </div>
            <div class="form-group">
                <input type="number" name="tax_per" required>
                <label>percentage Tax</label>
            </div>
            <div class="form-group">
                <input type="number" name="fixed_amount" required>
                <label>Fixed Amount</label>
            </div>
            {{-- <div class="form-group">
                <select name="status" required>
                    <option value="" disabled selected></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                   
                </select>
                <label>Status</label>
            </div> --}}
            <button class="create-btn" type="submit">Create</button>
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
                    <th>Tax cycle Name</th>
                    <th>Tax Type</th>
                    <th>Min Income</th>
                    <th>Max Income</th>
                    <th>Percentage</th>
                    <th>Fixed Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
             
                 
             @foreach ($datafortaxes as $data)

             <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->org_tax_regime_years_name }}</td>
                <td>{{$data->tax_type}}</td>
                <td>{{$data->min_income}}</td>
                <td>{{$data->max_income}}</td>
                <td>{{$data->tax_per}}</td>
                <td>{{$data->fixed_amount}}</td>
                <td>
                    <button class="edit-icon" onclick="openEditTaxSlabModal({{ $data->id }}, '{{ $data->org_tax_regime_years_name }}', '{{ $data->tax_type }}', '{{ $data->min_income }}', '{{ $data->max_income }}', '{{ $data->tax_per }}', '{{ $data->fixed_amount }}')">Edit</button>
                </td>
            </tr>
                 
             @endforeach
                 
                    
            </tbody>
        </table>
    </div>
            </div>
</div>

<div id="editTaxSlabModal" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal"> 
            <span onclick="document.getElementById('editTaxSlabModal').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Tax Slab</h2>
        </header>
        <div class="w3-container">
            <form id="editTaxSlabForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="tax_slab_id" id="editTaxSlabId">
                <div class="popup-form-group">
                    <label for="editTaxCycle">Tax Regime</label>
                    <select name="tax_cycle_type" id="editTaxCycle" required>
                        @foreach ($taxregim as $tax)
                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="popup-form-group">
                    <label for="editTaxType">Tax Type</label>
                    <select name="tax_type" id="editTaxType" required>
                        <option value="Income Tax">Income Tax</option>
                    </select>
                </div>
                <div class="popup-form-group">
                    <label for="editMinIncome">Min Income</label>
                    <input type="number" name="min_income" id="editMinIncome" required>
                </div>
                <div class="popup-form-group">
                    <label for="editMaxIncome">Max Income</label>
                    <input type="number" name="max_income" id="editMaxIncome" required>
                </div>
                <div class="popup-form-group">
                    <label for="editTaxPercentage">Percentage Tax</label>
                    <input type="number" name="tax_per" id="editTaxPercentage" required>
                </div>
                <div class="popup-form-group">
                    <label for="editFixedAmount">Fixed Amount</label>
                    <input type="number" name="fixed_amount" id="editFixedAmount" required>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditTaxSlabModal(id, taxCycleName, taxType, minIncome, maxIncome, taxPercentage, fixedAmount) {
        document.getElementById('editTaxSlabId').value = id;
        document.getElementById('editTaxCycle').value = taxCycleName;
        document.getElementById('editTaxType').value = taxType;
        document.getElementById('editMinIncome').value = minIncome;
        document.getElementById('editMaxIncome').value = maxIncome;
        document.getElementById('editTaxPercentage').value = taxPercentage;
        document.getElementById('editFixedAmount').value = fixedAmount;

        const formAction = "{{ route('update_tax_slab', ['id' => ':id']) }}".replace(':id', id);
        document.getElementById('editTaxSlabForm').action = formAction;

        document.getElementById('editTaxSlabModal').style.display = 'block';
    }
</script>

<script>
function showUserForm(clickedElement) {
    // Show form section and hide table section
    document.getElementById('formSection').style.display = 'block';
    document.getElementById('tableSection').style.display = 'none'; 
    const siblings = clickedElement.parentElement.children;
    for (let sibling of siblings) {
        sibling.classList.remove('active');
    } 
    clickedElement.classList.add('active');
}

    function showUserTable(clickedElement) {
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
    showUserTable(firstButton);
});
  
</script>

@endsection


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
        <h3>Create HR Policy</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showHRPolicyTable(this)">Show Table</button>
            <button onclick="showHRPolicyForm(this)">Show Form</button>
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
        <div id="formSection">
            @if($errors->any())
            <div class="alert custom-alert-warning">
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('save_hr_policy') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div  class="form-container row">

                <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="policy_title" name="policy_title" class="form-control" required>
                        <label for="policy_title">Policy Title</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="" disabled selected></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Select Category</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="policy_content" name="policy_content" class="form-control" required>
                        <label for="policy_content">Policy Content</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="file" id="document" name="document" class="form-control">
                        <label for="document">Upload Document</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="file" id="icon" name="icon" class="form-control">
                        <label for="icon">Upload Icon</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="file" id="content_image" name="content_image" class="form-control">
                        <label for="content_image">Upload Content Image</label>
                    </div>
                </div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <select id="category_id" name="status" class="form-control" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="category_id">Status</label>
                    </div>
                </div>
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Policy</button></div>
                </div>
            </form>
        </div>

     
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $datas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Title', 'accessor' => 'policy_title'],
                ['header' => 'Category', 'accessor' => 'policy_categorie_id'],
                ['header' => 'Status', 'accessor' => 'status'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
 
    </div>

    <div id="editHRPolicyModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editHRPolicyModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit HR Policy</h2>
            </header>
            <div class="w3-container">
                <form id="editHRPolicyForm" method="POST">  
                    @csrf
                    @method('POST')
                    <input type="hidden" name="policy_id" id="editHRPolicyId">
                    <div class="popup-form-group">
                        <input type="text" name="policy_title" id="editHRPolicyTitle" required>
                        <label for="editHRPolicyTitle">Policy Title</label>
                    </div>
                    <div class="popup-form-group">
                        <select name="category_id" id="editHRPolicyCategory" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="editHRPolicyCategory">Select Category</label>
                    </div>
                    <div class="popup-form-group">
                        <select name="status" id="editHRPolicyStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="editHRPolicyStatus">Status</label>
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
      

        function openEditModal(id, title,) { 
            document.getElementById('editHRPolicyId').value = title.id;
            document.getElementById('editHRPolicyTitle').value =  title.policy_title
            document.getElementById('editHRPolicyCategory').value = title.policy_categorie_id;
            document.getElementById('editHRPolicyStatus').value = title.status;

            const formAction = "{{ route('update_hr_policy', ['id' => ':id']) }}".replace(':id', title.id);
            document.getElementById('editHRPolicyForm').action = formAction;

            document.getElementById('editHRPolicyModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

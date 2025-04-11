@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($leaveCycleDatas);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}"> 
    
</head>
<body>
    <div class="container">
        <h3>Create Leave Policy Cycle</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showLeaveSlotTable(this)">Show Table</button>
            <button onclick="showLeaveSlotForm(this)">Show Form</button>
        </div>

        <!-- Form Section -->
        <div id="formSection" >
            <form action="{{ route('insert_policy_slot') }}" method="POST" >
                @csrf
                <div class="form-container row">
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="text" id="category_name" name="cycle_name" class="form-control" required>
                        <label for="category_name">Cycle Name</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" id="category_name" name="start_date_time" class="form-control" required>
                        <label for="category_name">Start Date Time</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input type="datetime-local" id="category_name" name="end_date_time" class="form-control" required>
                        <label for="category_name">End Date Time</label>
                    </div>
</div>
                    <div class="col-3 mb-4">
                    <div class="form-group">
                        <input id="text" id="category_name" name="year_slot" class="form-control" required>
                        <label for="year">Input Year: (EX: 2025-26)</label>
                    </div>
</div>
                    <div class="col-12">
                    <button type="submit" class="create-btn" >Save Cycle</button>
                    </div>
                </div>
            </form>
        </div>
  
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $leaveCycleDatas,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Name', 'accessor' => 'name'],
                ['header' => 'Start', 'accessor' => 'start_date'],
                ['header' => 'End', 'accessor' => 'end_date'],
                ['header' => 'Year', 'accessor' => 'year'], 
            ],
            'editModalId' => 'openEditUserModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>


    </div>

    <div id="editLeaveSlotModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeaveSlotModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Policy Cycle</h2>
            </header>
            <div class="w3-container">
                <form id="editLeaveSlotForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="cycle_id" id="editLeaveSlotId">
                    <div class="popup-form-group">
                        <label for="editLeaveSlotName">Cycle Name</label>
                        <input type="text" name="cycle_name" id="editLeaveSlotName" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotStartDate">Start Date Time</label>
                        <input type="datetime-local" name="start_date_time" id="editLeaveSlotStartDate" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotEndDate">End Date Time</label>
                        <input type="datetime-local" name="end_date_time" id="editLeaveSlotEndDate" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveSlotYear">Year</label>
                        <input type="text" name="year_slot" id="editLeaveSlotYear" required>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLeaveSlotForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showLeaveSlotTable(clickedElement) {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'block';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        // Ensure the table is visible by default on page load 
        document.addEventListener('DOMContentLoaded', () => {
            const firstButton = document.querySelector('.toggle-buttons button:first-child');
            showLeaveSlotTable(firstButton);
        }); 
        function openEditModal(id, leavs) {
            if (!id) {
                alert('Invalid leave slot data. Please try again.');
                return;
            }
            document.getElementById('editLeaveSlotId').value = leavs.id;
            document.getElementById('editLeaveSlotName').value = leavs.name || '';
            document.getElementById('editLeaveSlotStartDate').value = leavs.start_date || '';
            document.getElementById('editLeaveSlotEndDate').value = leavs.end_date || '';
            document.getElementById('editLeaveSlotYear').value = leavs.year || '';

            const formAction = "{{ route('update_policy_slot', ['id' => ':id']) }}".replace(':id', leavs.id);
            document.getElementById('editLeaveSlotForm').action = formAction;

            document.getElementById('editLeaveSlotModal').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

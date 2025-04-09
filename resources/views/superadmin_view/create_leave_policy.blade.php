@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->
@section('content')  <!-- Defining the content section -->
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<?php 
$id = Auth::guard('superadmin')->user()->id;
// dd($datas);
// dd($results);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}"> 
    
</head>
<body>
    <div class="container">
        <h3>Create Leave Policy</h3>

        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
        <button onclick="showLeavePolicyTable(this)">Show Table</button>
        <button onclick="showLeavePolicyForm(this)">Show Form</button>
        </div>
    {{-- @endif --}}
    
    {{-- @if(session('error'))
    <div class="alert custom-alert-error">
        <strong> {{ session('error') }}</strong>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif  --}}

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
        <div id="formSection" style="display: none;">
            <form action="{{ route('insertPolicyConf') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <select id="category_id" name="leave_type_id" class="form-control" required>
                        <option value="" disabled selected></option>
                        @foreach ($results as $result)
                            <option value="{{ $result->leave_type_id }}">{{ $result->leave_type }}</option>
                        @endforeach
                    </select>
                    <label for="category_id">Select Leave Type</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="max_leave_count" class="form-control" required>
                    <label for="category_name">Max Leave</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="max_leave_at_time" class="form-control" required>
                    <label for="category_name">Max Leave At Time</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="min_leave_at_time" class="form-control" required step="0.5">
                    <label for="category_name">Min Leave At Time</label>
                </div>

                <div class="form-group">
                    <input type="number" id="category_name" name="leave_count_per_month" class="form-control" required step="0.5">
                    <label for="category_name">Leave Count Per Month</label>
                </div>

                <div class="form-group">
                    <input type="number" id="category_name" name="no_of_leaves_per_month" class="form-control" required step="0.5">
                    <label for="category_name">No of Times Per Months</label>
                </div>

                <div class="form-group">
                    <select id="category_id" name="is_carry_forward" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option> 
                    </select>
                    <label for="category_name">Is Carry Forward?</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="no_of_carry_forward" class="form-control" required>
                    <label for="category_name">No. Of Carry Forward</label>
                </div>
                <div class="form-group">
                    <select id="category_id" name="leave_encash" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option> 
                    </select>
                    <label for="category_name">Is Leave Encash?</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="leave_encash_count" class="form-control" required>
                    <label for="category_name">No. Of Leave Encash</label>
                </div>

                <div class="form-group">
                    <select id="category_id" name="provision_status" class="form-control" required>
                        <option value="" disabled selected></option>
                        <option value="Applicable">Applicable</option>
                        <option value="Not Applicable">Not Applicable</option> 
                    </select>
                    <label for="category_name">Provision Status</label>
                </div>
    
                <div class="form-group">
                    <input type="number" id="category_name" name="max_leave_pp" class="form-control" required>
                    <label for="category_name">Max Leave Probation Period</label>
                </div>
                <div class="form-group">
                    <input type="number" id="category_name" name="probation_period_per_month" class="form-control" required>
                    <label for="category_name">Probation Period Per Month</label>
                </div>
    
                <div class="form-group">
                    <input type="number" id="category_name" name="calendra_start_for_PP" class="form-control" required>
                    <label for="category_name">Calendra Start For PP</label>
                </div>
                <button type="submit" class="create-btn" >Save Type</button>
            </form>
        </div>
 
    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $dataFromLeaveRestctions,
            'columns' => [
                ['header' => 'Id', 'accessor' => 'id'],
                ['header' => 'Leave Type', 'accessor' => 'leave_type'],
                ['header' => 'Max Leave', 'accessor' => 'max_leave'],
                ['header' => 'Max Leave At Time', 'accessor' => 'max_leave_at_time'],
                ['header' => 'Min Leave At Time', 'accessor' => 'min_leave_at_time'],
                ['header' => 'Leave Count Per Month', 'accessor' => 'leave_count_per_month'],
                ['header' => 'No of Times Per Month', 'accessor' => 'no_of_time_per_month'],
                ['header' => 'Carry Forward', 'accessor' => 'carry_forward'],
                ['header' => 'No. of Carry Forward', 'accessor' => 'no_carry_forward'],
                ['header' => 'Encash', 'accessor' => 'leave_encash'],
                ['header' => 'No. of Encash', 'accessor' => 'no_leave_encash'],
                ['header' => 'Provision Status', 'accessor' => 'provision_status'],
                ['header' => 'Max Leave Probation Period', 'accessor' => 'max_leave_PP'],
                ['header' => 'Probation Period Per Month', 'accessor' => 'provision_period_per_month'],
                ['header' => 'Calendra Start For PP', 'accessor' => 'calendra_start_for_PP'], 
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
    </div>

    <div id="editLeavePolicyModal" class="w3-modal" style="display: none;">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-teal"> 
                <span onclick="document.getElementById('editLeavePolicyModal').style.display='none'" 
                class="w3-button w3-display-topright">&times;</span>
                <h2>Edit Leave Policy</h2>
            </header>
            <div class="w3-container">
                <form id="editLeavePolicyForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="policy_id" id="editLeavePolicyId">
                    <div class="popup-form-group">
                        <label for="editLeaveType">Leave Type</label>
                        <input type="text" id="editLeaveType" disabled>
                    </div>
                    <div class="popup-form-group">
                        <label for="editMaxLeave">Max Leave</label>
                        <input type="number" name="max_leave_count" id="editMaxLeave" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editMaxLeaveAtTime">Max Leave At Time</label>
                        <input type="number" name="max_leave_at_time" id="editMaxLeaveAtTime" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editMinLeaveAtTime">Min Leave At Time</label>
                        <input type="number" name="min_leave_at_time" id="editMinLeaveAtTime" required step="0.5">
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveCountPerMonth">Leave Count Per Month</label>
                        <input type="number" name="leave_count_per_month" id="editLeaveCountPerMonth" required step="0.5">
                    </div>
                    <div class="popup-form-group">
                        <label for="editNoOfTimesPerMonth">No of Times Per Month</label>
                        <input type="number" name="no_of_leaves_per_month" id="editNoOfTimesPerMonth" required step="0.5">
                    </div>
                    <div class="popup-form-group">
                        <label for="editCarryForward">Carry Forward</label>
                        <select name="is_carry_forward" id="editCarryForward" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editNoOfCarryForward">No. Of Carry Forward</label>
                        <input type="number" name="no_of_carry_forward" id="editNoOfCarryForward" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editLeaveEncash">Leave Encash</label>
                        <select name="leave_encash" id="editLeaveEncash" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editNoOfLeaveEncash">No. Of Leave Encash</label>
                        <input type="number" name="leave_encash_count" id="editNoOfLeaveEncash" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editProvisionStatus">Provision Status</label>
                        <select name="provision_status" id="editProvisionStatus" required>
                            <option value="Applicable">Applicable</option>
                            <option value="Not Applicable">Not Applicable</option>
                        </select>
                    </div>
                    <div class="popup-form-group">
                        <label for="editMaxLeavePP">Max Leave Probation Period</label>
                        <input type="number" name="max_leave_pp" id="editMaxLeavePP" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editProbationPeriodPerMonth">Probation Period Per Month</label>
                        <input type="number" name="probation_period_per_month" id="editProbationPeriodPerMonth" required>
                    </div>
                    <div class="popup-form-group">
                        <label for="editCalendraStartForPP">Calendra Start For PP</label>
                        <input type="number" name="calendra_start_for_PP" id="editCalendraStartForPP" required>
                    </div>
                    <div class="popup-form-group">
                        <button class="create-btn1" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLeavePolicyForm(clickedElement) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('tableSection').style.display = 'none';
            const siblings = clickedElement.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('active');
            } 
            clickedElement.classList.add('active');
        }

        function showLeavePolicyTable(clickedElement) {
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
            showLeavePolicyTable(firstButton);
        });
       

        function openEditModal(id, leavedata) {
            document.getElementById('editLeavePolicyId').value = leavedata.id;
            document.getElementById('editLeaveType').value = leavedata.leave_type;
            document.getElementById('editMaxLeave').value = leavedata.max_leave;
            document.getElementById('editMaxLeaveAtTime').value = leavedata.max_leave_at_time;
            document.getElementById('editMinLeaveAtTime').value = leavedata.min_leave_at_time;
            document.getElementById('editLeaveCountPerMonth').value = leavedata.leave_count_per_month;
            document.getElementById('editNoOfTimesPerMonth').value = leavedata.no_of_time_per_month;
            document.getElementById('editCarryForward').value = leavedata.carry_forward;
            document.getElementById('editNoOfCarryForward').value = leavedata.no_carry_forward;
            document.getElementById('editLeaveEncash').value = leavedata.leave_encash;
            document.getElementById('editNoOfLeaveEncash').value = leavedata.no_leave_encash;
            document.getElementById('editProvisionStatus').value = leavedata.provision_status;
            document.getElementById('editMaxLeavePP').value = leavedata.max_leave_PP;
            document.getElementById('editProbationPeriodPerMonth').value = leavedata.provision_period_per_month;
            document.getElementById('editCalendraStartForPP').value = leavedata.calendra_start_for_PP;

            const formAction = "{{ route('update_policy_conf', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editLeavePolicyForm').action = formAction;

            document.getElementById('editLeavePolicyModal').style.display = 'block';
        }
    </script>
@endsection


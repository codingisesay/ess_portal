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
    <title>Create Leave Policy</title>
    
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
    <li style="color: red;">{{ $error }}</li>
    
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
        <div id="tableSection" >
    
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Leave Type</th>
                            <th>Max Leave</th>
                            <th>Max Leave At Time</th>
                            <th>Min Leave At Time</th>
                            <th>Leave Count Per Month</th>
                            <th>No of Times Per Month</th>
                            <th>Carry Forward</th>
                            <th>No. of Carry Forward</th>
                            <th>Encash</th>
                            <th>No. of Encash</th>

                            <th>Provision Status</th>
                            <th>Max Leave Probation Period</th>
                            <th>Probation Period Per Month</th>
                            <th>Calendra Start For PP</th>
                            <th>Edit</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataFromLeaveRestctions as $dataFromLeaveRestction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dataFromLeaveRestction->leave_type }}</td>
                                <td>{{ $dataFromLeaveRestction->max_leave }}</td>
                                <td>{{ $dataFromLeaveRestction->max_leave_at_time }}</td>
                                <td>{{ $dataFromLeaveRestction->min_leave_at_time }}</td>

                                <td>{{ $dataFromLeaveRestction->leave_count_per_month }}</td>
                                <td>{{ $dataFromLeaveRestction->no_of_time_per_month }}</td>   


                                <td>{{ $dataFromLeaveRestction->carry_forward }}</td>
                                <td>{{ $dataFromLeaveRestction->no_carry_forward }}</td>
                                <td>{{ $dataFromLeaveRestction->leave_encash }}</td>
                                <td>{{ $dataFromLeaveRestction->no_leave_encash }}</td>

                                <td>{{ $dataFromLeaveRestction->provision_status }}</td>
                                <td>{{ $dataFromLeaveRestction->max_leave_PP }}</td>
                                <td>{{ $dataFromLeaveRestction->provision_period_per_month }}</td>
                                <td>{{ $dataFromLeaveRestction->calendra_start_for_PP }}</td>
                                <td>
                                    <button class="edit-icon" onclick="openEditLeavePolicyModal({{ $dataFromLeaveRestction->id }}, '{{ $dataFromLeaveRestction->leave_type }}', '{{ $dataFromLeaveRestction->max_leave }}', '{{ $dataFromLeaveRestction->max_leave_at_time }}', '{{ $dataFromLeaveRestction->min_leave_at_time }}', '{{ $dataFromLeaveRestction->leave_count_per_month }}', '{{ $dataFromLeaveRestction->no_of_time_per_month }}', '{{ $dataFromLeaveRestction->carry_forward }}', '{{ $dataFromLeaveRestction->no_carry_forward }}', '{{ $dataFromLeaveRestction->leave_encash }}', '{{ $dataFromLeaveRestction->no_leave_encash }}', '{{ $dataFromLeaveRestction->provision_status }}', '{{ $dataFromLeaveRestction->max_leave_PP }}', '{{ $dataFromLeaveRestction->provision_period_per_month }}', '{{ $dataFromLeaveRestction->calendra_start_for_PP }}')">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

        // Ensure the form is visible by default on page load
        document.addEventListener('DOMContentLoaded', () => {
            showLeavePolicyForm();
        });

        function openEditLeavePolicyModal(id, leaveType, maxLeave, maxLeaveAtTime, minLeaveAtTime, leaveCountPerMonth, noOfTimesPerMonth, carryForward, noOfCarryForward, leaveEncash, noOfLeaveEncash, provisionStatus, maxLeavePP, probationPeriodPerMonth, calendraStartForPP) {
            document.getElementById('editLeavePolicyId').value = id;
            document.getElementById('editLeaveType').value = leaveType;
            document.getElementById('editMaxLeave').value = maxLeave;
            document.getElementById('editMaxLeaveAtTime').value = maxLeaveAtTime;
            document.getElementById('editMinLeaveAtTime').value = minLeaveAtTime;
            document.getElementById('editLeaveCountPerMonth').value = leaveCountPerMonth;
            document.getElementById('editNoOfTimesPerMonth').value = noOfTimesPerMonth;
            document.getElementById('editCarryForward').value = carryForward;
            document.getElementById('editNoOfCarryForward').value = noOfCarryForward;
            document.getElementById('editLeaveEncash').value = leaveEncash;
            document.getElementById('editNoOfLeaveEncash').value = noOfLeaveEncash;
            document.getElementById('editProvisionStatus').value = provisionStatus;
            document.getElementById('editMaxLeavePP').value = maxLeavePP;
            document.getElementById('editProbationPeriodPerMonth').value = probationPeriodPerMonth;
            document.getElementById('editCalendraStartForPP').value = calendraStartForPP;

            const formAction = "{{ route('update_policy_conf', ['id' => ':id']) }}".replace(':id', id);
            document.getElementById('editLeavePolicyForm').action = formAction;

            document.getElementById('editLeavePolicyModal').style.display = 'block';
        }
    </script>
@endsection


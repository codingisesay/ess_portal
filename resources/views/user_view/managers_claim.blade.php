@extends('user_view.header')
@section('content')
<?php 
error_reporting(0);
?>
 
<link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 

<div class="mx-4">
    <h2>
        <span onclick="history.back()"> &lt; </span>
        Reimbursement Claims for Tracking ID: <strong>{{ $managerClaims->first()->token_number ?? 'N/A' }}</strong>
    </h2>
    <div class="claim-panel p-3">
        @foreach ($managerClaims as $claim)
        <p class="claim-summary m-0">Employee Name: <strong>{{ $claim->employee_name }}</strong></p>
        <div>
            <hr>
            <form action="{{ route('update.finance.reimbursement', $reimbursement_traking_id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" id="status" value="">
                @method('PUT')
            <p class="">Description: <strong>{{ $claim->description }}</strong></p>
            <div class="tbl-container"> <!-- Open by default -->
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Entered Amount</th>
                            <th>Bill</th>
                            <th>Applicant Comment</th>
                            <th>Manager Remark</th>
                            <th>Action</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($claim->entry_date)->format('d/m/Y') }}</td>
                            <td>{{ number_format($claim->entry_amount, 2) }}</td>
                            <td>
                                @if ($claim->upload_bill)
                                <a href="{{ asset('storage/' . $claim->upload_bill) }}" target="_blank" class="text-decoration-none" title="open in new tab">
                                    <x-icon name="newtab" />
                                </a>
                                @else
                                No Bill Uploaded
                                @endif
                            </td>
                            <td>{{ $claim->description_by_applicant }}</td>
                            <td>{{ $claim->description_by_manager }}</td>
                            <td> 
                                <label class="toggle-switch">
                                    <input type="checkbox" checked="">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                            <input type="text" name="remarks[{{ $claim->entry_id }}]" class="form-control" placeholder="Enter Finance Remark" value="">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Total Amount:</td>
                            <td colspan="4" style="font-weight: bold;">Rs. {{ number_format($claim->total_amount, 2) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="floating-label-wrapper">
                            <!-- <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Description" class="input-field" required> -->
                            <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Description" class="input-field" required>
                            <label for="task">Task</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end mt-2">
                <button type="button" class="py-1 mx-1 px-3 btn-warning text-white" onclick="submitForm('REVERT')">Revert</button>
                <button type="button" class="py-1 mx-1 px-3 btn-danger" onclick="submitForm('REJECTED')">Reject</button>
                <button type="button" class="py-1 mx-1 px-3 btn-success" onclick="submitForm('APPROVED')">Approve</button>
                </div>
            </div>
        </div>
        @endforeach
        </form>
    </div>
</div>


<script>
    function toggleBody(header) {
        const body = header.nextElementSibling;
        body.style.display = body.style.display === 'block' ? 'none' : 'block';
    }
</script>
<script>
    function submitForm(status) {
        // Set the status input value
        document.getElementById('status').value = status;

        // Submit the form
        const form = event.target.closest('form');
        if (form) {
            form.submit();
        } else {
            console.error('Form not found.');
        }
    }
</script>
@endsection

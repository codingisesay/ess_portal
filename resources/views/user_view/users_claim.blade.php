@extends('user_view.header')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Claims Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 
</head>
<body>
<div class="mx-4">
    <h2>
        <span  onclick="history.back()" > &lt; </span>
         Reimbursement Claims        
    </h2>
    @if ($reimbursementList->isNotEmpty())
        @php 
            $reimbursement = $reimbursementList->first(); 
            $totalAmount = $reimbursementList->sum('entry_amount'); // Calculate total amount
        @endphp
        <div class="claim-panel p-3">
        <p class="claim-summary m-0" onclick="toggleBody(this)">Tracking ID :<strong> {{ $reimbursement->token_number }} </strong></p>
        <div>
            <hr>
            <form action="{{ route('update_reimbursement_status', $reimbursement_traking_id) }}" method="POST">
    @csrf
    <input type="hidden" name="status" id="status" value="">
            <!-- <p class="claim-summary">Total Amount: Rs. {{ number_format($reimbursement->total_amount, 2) }}</p> -->
            <p class="">Description:<strong> {{ $reimbursement->description }}</strong></p>
                <div class=" tbl-container "> <!-- Open by default -->
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Date</th>
                                <th>Claim Type</th>
                                <th>Max Amount</th>
                                <th>Entered Amount</th>
                                <th>Bill</th>
                                <th>Applicant Comment</th>
                                <th>Action</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $serial = 1; @endphp
                            @foreach ($reimbursementList as $detail)
                            <tr>
                                <td>{{ $serial++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($detail->entry_date)->format('d/m/Y') }}</td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $reim_type->type_name }}" disabled>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-end" value="{{ $reim_type->max_amount }}" disabled>
                                </td>
                                <td class="text-end">{{ number_format($detail->entry_amount, 2) }}</td>
                                <td>
                                    @if ($detail->upload_bill)
                                        <a href="{{ asset('storage/' . $detail->upload_bill) }}" target="_blank" class="text-decoration-none" title="open in new tab">
                                            <x-icon name="newtab" />
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $detail->description_by_applicant }}</td>
                                <td>
                                    <!-- {{ $detail->status }}  -->
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked />
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td>
                                <input type="text" name="remarks[{{ $detail->entry_id }}]" value="" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight: bold;">Total Amount:</td>
                                <td  class="fw-bold text-end">Rs. {{ number_format($totalAmount, 2) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row ">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="floating-label-wrapper">
                                <input type="text" maxlength="200" id="task" name="task_name" placeholder="Task Description" class="input-field" required>
                                <label for="task">Task</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end  mt-2">
                   
                        <!-- <input type="hidden" name="status" id="status" value=""> -->
                        <button type="button" class="py-1 mx-1 px-3 btn-warning text-white" onclick="submitForm('REVERT')">Revert</button>
                        <button type="button" class="py-1 mx-1 px-3 btn-danger" onclick="submitForm('REJECTED')">Reject</button>
                        <button type="button" class="py-1 mx-1 px-3 btn-success" onclick="submitForm('APPROVED BY MANAGER')">Approve</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center w-100 text-secondary">No claim details found for the provided tracking ID and user.</p>
    @endif
</div>

<script>
    function toggleBody(header) {
        const body = header.nextElementSibling;
        body.style.display = body.style.display === 'block' ? 'none' : 'block';
    }
</script>
<script>
    function submitForm(status) {
        // Set the remark input value to the status
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


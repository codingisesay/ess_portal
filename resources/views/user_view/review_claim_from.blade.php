@extends('user_view.header')
@section('content')
<head>
 
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
 <!-- Option 1: Include in HTML --> 
  <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}"> 
  <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}"> 
 

     

<div class="mx-3">
    <h2><span class="back-btn mx-2" onclick="history.back()"> &lt; </span>Review Reimbursement For : {{ $tokenNumber }}</h2>
    <div class="reimbursement-details">
        <table >
            <thead>
                <tr>
                    <th>Entry Date</th>
                    <th>Type</th>
                    <th>Description by Applicant</th>
                    <th>Entry Amount</th>
                    <th>Status</th>
                    <th>Upload Bill</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reimbursementClaims as $claim)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($claim->entry_date)->format('d/m/Y') }}</td>
                        <td>{{ $claim->type_name }}</td>
                        <td>{{ $claim->description_by_applicant }}</td>
                        <td class="text-end" >₹{{ number_format($claim->entry_amount, 2) }}</td>
                        <td>
                            <span class="{{ $claim->status == 'In Review' ? 'review' : '' }}">
                                {{ $claim->status }}
                            </span>
                        </td>
                        <td class='text-center'>
                            @if ($claim->upload_bill)
                                <a href="{{ asset('storage/' . $claim->upload_bill) }}" target="_blank"><x-icon name="newtab" />
                                </a>
                            @else
                                No Bill Uploaded
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteRow(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>
@endsection
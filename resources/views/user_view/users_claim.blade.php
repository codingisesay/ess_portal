@extends('user_view.header')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Claims Page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="claim-container">
    <h2 class="claim-summary">Reimbursement Claim Details</h2>
    @if ($reimbursementList->isNotEmpty())
        @php $reimbursement = $reimbursementList->first(); @endphp
        <p class="claim-summary">Tracking ID:{{ $reimbursement->token_number }}</p>
        <p class="claim-summary">Total Amount: Rs. {{ number_format($reimbursement->total_amount, 2) }}</p>
        <!-- <p class="claim-summary">Status: {{ $reimbursement->status }}</p> -->
        <!-- <p class="claim-summary">Start Date: {{ \Carbon\Carbon::parse($reimbursement->start_date)->format('d/m/Y') }}</p>
        <p class="claim-summary">End Date: {{ \Carbon\Carbon::parse($reimbursement->end_date)->format('d/m/Y') }}</p> -->
        <p class="claim-summary">Description: {{ $reimbursement->description }}</p>

        <div class="claim-panel">
            <div class="claim-header" onclick="toggleBody(this)">Claim Details</div>
            <div class="claim-body" style="display: block;"> <!-- Open by default -->
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Entered Amount</th>
                            <th>Bill</th>
                            <th>Applicant Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $serial = 1; @endphp
                        @foreach ($reimbursementList as $detail)
                        <tr>
                            <td>{{ $serial++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->entry_date)->format('d/m/Y') }}</td>
                            <td>{{ number_format($detail->entry_amount, 2) }}</td>
                            <td>
                                @if ($detail->upload_bill)
                                    <a href="{{ asset('storage/' . $detail->upload_bill) }}" target="_blank">View Bill</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $detail->description_by_applicant }}</td>
                            <td>{{ $detail->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="claim-summary">No claim details found for the provided tracking ID and user.</p>
    @endif
</div>

<script>
    function toggleBody(header) {
        const body = header.nextElementSibling;
        body.style.display = body.style.display === 'block' ? 'none' : 'block';
    }
</script>

<style>
  /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.claim-container {
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}

.claim-container h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.claim-summary {
    margin-bottom: 10px;
    color: #666;
}

.claim-panel {
    background-color: #ffffff;
    margin-bottom: 25px;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
}

.claim-header {
    padding: 15px 20px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    background: #ffffff;
    color: #333;
    transition: background 0.3s ease;
}

.claim-header:hover {
    background: #ffffff;
}

.claim-body {
    display: none;
    padding: 20px;
    background-color: #fff;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.custom-table th,
.custom-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.custom-table th {
    background-color: #E0AFA0;
}

.custom-table tr:nth-child(even) {
    background-color: #fff;
}

.custom-table tr:nth-child(odd) {
    background-color: #f9f9f9;
}

textarea {
    display: none;
    margin-top: 5px;
    width: 100%;
    padding: 8px;
    font-size: 14px;
    resize: none;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.button-group {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.button-group button {
    padding: 10px 20px;
    background-color: #8A3366;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.button-group button:hover {
    background-color: #9b4bab;
}
</style>

</body>
</html>
@endsection


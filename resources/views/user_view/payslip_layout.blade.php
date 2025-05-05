<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Payslip for {{ $salaryMonth }}</h2>
        <p>Employee No: {{ $employee->employee_no }}</p>
        <p>Employee Name: {{ $employee->employee_name }}</p>
        <p>Joining Date: {{ \Carbon\Carbon::parse($employee->joining_date)->format('d-M-Y') }}</p>
        <p>Designation: {{ $employee->designation }}</p>
        <p>Provident Fund: {{ $employee->provident_fund }}</p>
        <p>ESIC No: {{ $employee->esic_no }}</p>
        <p>Universal Account Number: {{ $employee->universal_account_number }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Component Name</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($components as $component)
                <tr>
                    <td>{{ $component->component_name }}</td>
                    <td>{{ ucfirst($component->component_type) }}</td>
                    <td>₹{{ number_format($component->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Earnings</th>
                <th>₹{{ number_format($totalEarnings, 2) }}</th>
            </tr>
            <tr>
                <th colspan="2">Total Deductions</th>
                <th>₹{{ number_format($totalDeductions, 2) }}</th>
            </tr>
            <tr>
                <th colspan="2">Net Amount</th>
                <th>₹{{ number_format($netAmount, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
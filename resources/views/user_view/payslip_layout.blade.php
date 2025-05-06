<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
           position:relative;text-align:center
        }
        .header img{
            position:fixed;
            top:10px;
            left:10px;
        }
     
        .company-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
       
        .company-address {
            margin-bottom: 20px;font-size:14px;
        }
        .payslip-title {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.border, table.border th, table.border td {
            border: 1px solid lightgray;
        }
        th, td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
  
        .earnings-deductions {
            width: 100%;
        }
        .total-row {
            font-weight: bold;
        }
        .net-pay {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            font-size: 16px;
        }
        .footer{font-size:12px;color:lightgray;text-align:center;margin-top:30px}
    </style>
</head>
<body>
    <div class="header">
        <img width="150px" src="{{ asset('user_end/images/STPL Logo with TagLine HD Transparent.png') }}" alt="STPL Logo">
        <div class="header-text">
            <div class="company-name">Payvance</div>
            <small class="company-address">
                #A112, "Centrum Business Square"<br/>
                Plot D1, Road No 16, Wagle Industrial Estate</br>
                Thane West - 400604</br>
                <b>CIN: U72200MH2014PTC253445</b> 
            </small>
            <div class="payslip-title">Payslip for the month of {{ $salaryMonth }}</div>
        </div>
    </div>

    <table > 
        <tr> 
            <td>Employee No:</td>
            <td> {{ $employee->employee_no }}</td> 
            <td>Employee Name:</td> 
            <td> {{ $employee->employee_name }}</td>
        </tr>
        <tr> 
            <td>Joining Date:</td>
            <td> {{ \Carbon\Carbon::parse($employee->joining_date)->format('d-M-Y') }}</td> 
            <td>Designation:</td>
            <td> {{ $employee->designation }}</td>
        </tr>
        <tr> 
            <td>Provident Fund:</td>
            <td> {{ $employee->provident_fund }}</td> 
            <td>ESIC No:</td>
            <td> {{ $employee->esic_no }}</td>
        </tr>
        <tr> 
            <td>UAN:</td>
            <td> {{ $employee->universal_account_number }}</td>
        </tr>
    </table>
 
    <table >
        <tr>
            <td>
            <table class="border">
                <thead>
                    <tr>
                        <th>Earning</th>
                        <!-- <th>Type</th> -->
                        <th>Amount</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($components as $component)
                    @if  ( $component->component_type   ===  'Earning')
                        <tr>
                            <td>{{ $component->component_name }}</td>
                            <!-- <td>{{ ucfirst($component->component_type) }}</td> -->
                            <td>₹{{ number_format($component->amount, 2) }}</td>
                        </tr> 
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th >Total Earnings</th>
                        <th>₹{{ number_format($totalEarnings, 2) }}</th>
                    </tr> 
                </tfoot>
            </table>
            </td>
       
            <td>
                <table class="border">
                    <thead>
                        <tr> 
                            <th>Desuction</th>
                            <!-- <th>Type</th> -->
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($components as $component)
                        @if  ( $component->component_type   ===  'Deduction')
                            <tr>
                                <td>{{ $component->component_name }}</td>
                                <!-- <td>{{ ucfirst($component->component_type) }}</td> -->
                                <td>₹{{ number_format($component->amount, 2) }}</td>
                            </tr> 
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot> 
                        <tr>
                            <th >Total Deductions</th>
                            <th>₹{{ number_format($totalDeductions, 2) }}</th>
                        </tr> 
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>

        <table>
            <tr>
                <td>
                Net Pay for the month in number<br/><b> ₹{{ number_format($netAmount, 2) }} </b>
                </td>
                <td>
                Net Pay for the month in words<br/><b> ₹{{ number_format($netAmount, 2) }} </b>
                </td>
            </tr>
        </table>
     
    <div class="footer ">
        <span>This is a system generated payslip and does not require signature.</span><br>
        <span>Generated by Payvance</span>
    </div>
</body>
</html>
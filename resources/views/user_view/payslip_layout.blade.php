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
            <td> {{ $employee->employee_no ?? '-' }}</td> 
            <td>Employee Name:</td> 
            <td> {{ $employee->employee_name ?? '-' }}</td>
        </tr>
        <tr> 
            <td>Joining Date:</td>
            <td> {{ \Carbon\Carbon::parse($employee->joining_date)->format('d-M-Y') ?? '-' }}</td> 
            <td>Designation:</td>
            <td> {{ $employee->designation ?? '-' }}</td>
        </tr>
        <tr> 
            <td>Provident Fund:</td>
            <td> {{ $employee->provident_fund ?? '-' }}</td> 
            <td>ESIC No:</td>
            <td> {{ $employee->esic_no ?? '-' }}</td>
        </tr>
        <tr> 
            <td>UAN:</td>
            <td> {{ $employee->universal_account_number ?? '-' }}</td>
            <td>Passport Number</td>
            <td>{{ $bankDetails->passport_number ?? '-' }}</td>
        </tr>
        <tr> 
            <td>Bank Name</td>
        <td>{{ $bankDetails->bank_name ?? '-' }}</td>
             <td>Branch</td>
        <td>{{ $bankDetails->sal_branch_name ?? '-' }}</td>
        </tr>
        <tr> 
           <td>Account Number</td>
        <td>{{ $bankDetails->sal_account_number ?? '-' }}</td>
         <td>Visa Expiry Date</td>
         <td>{{ !empty($bankDetails->visa_expiry_date) ? \Carbon\Carbon::parse($bankDetails->visa_expiry_date)->format('d-M-Y') : '-' }}</td>
        </tr>
    
    </table>
 
    <table >
        <tr>
          <td>
    <!-- Earnings Table -->
    <table class="border">
        <thead>
            <tr>
                <th>Earning</th>
                <th>Amount</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($components as $component)
                @if ($component->component_type === 'Earning')
                    <tr>
                        <td>{{ $component->component_name }}</td>
                        <td>₹{{ number_format($component->amount, 2) }}</td>
                    </tr> 
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total Earnings</th>
                <th>₹{{ number_format($totalEarnings, 2) }}</th>
            </tr> 
        </tfoot>
    </table>

    <!-- Leave Summary Table (under Earnings) -->
    <table class="border" style="margin-top:10px;">
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Total Days</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leaveSummary as $leave)
                <tr>
                    <td>{{ $leave->leave_type_name }}</td>
                    <td>{{ $leave->total_days }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No approved leaves</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</td>
            
       
            <td>
                <table class="border">
                    <thead>
                        <tr> 
                            <th>Deductions</th>
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
                <!-- <td>
                Net Pay for the month in number<br/><b> ₹{{ number_format($netAmount, 2) }} </b>
                </td> -->
                <td>
                    Net Pay for the month<br/>
                    <b id="netAmount">₹{{ number_format($netAmount, 2) }}</b><br/>
                    <i id="amountInWords"></i>
                </td>
            </tr>
        </table>
     
    <div class="footer ">
        <span>This is a system generated payslip and does not require signature.</span><br>
        <span>Generated by Payvance</span>
    </div>

    <script>
function numberToWords(num) {
    const a = [
        '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
        'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen',
        'seventeen', 'eighteen', 'nineteen'
    ];
    const b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function inWords(n) {
        if ((n = n.toString()).length > 9) return 'overflow';
        let n_num = ('000000000' + n).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{3})$/);
        if (!n_num) return;
        let str = '';
        str += (n_num[1] != 0) ? (a[Number(n_num[1])] || b[n_num[1][0]] + ' ' + a[n_num[1][1]]) + ' crore ' : '';
        str += (n_num[2] != 0) ? (a[Number(n_num[2])] || b[n_num[2][0]] + ' ' + a[n_num[2][1]]) + ' lakh ' : '';
        str += (n_num[3] != 0) ? (a[Number(n_num[3])] || b[n_num[3][0]] + ' ' + a[n_num[3][1]]) + ' thousand ' : '';
        str += (n_num[4] != 0) ? (a[Number(n_num[4])] || b[n_num[4][0]] + ' ' + a[n_num[4][1]]) + ' ' : '';
        return str.trim();
    }

    const parts = num.toString().split('.');
    const rupees = inWords(parts[0]);
    const paise = parts[1] ? inWords(parts[1]) : '';

    return rupees.charAt(0).toUpperCase() + rupees.slice(1) + ' Rupees' + (paise ? ' and ' + paise + ' Paise' : '');
}

// Grab the net amount from the page (remove ₹ and commas)
const rawAmount = document.getElementById('netAmount').innerText.replace(/[₹,]/g, '');
const amountInWords = numberToWords(parseFloat(rawAmount));
document.getElementById('amountInWords').innerText = amountInWords;
</script>
</body>
</html>
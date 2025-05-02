 
  <title>Salary Table</title>
  

<link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
<link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
<link rel="stylesheet" href="{{ asset('user_end/css/homepage.css') }}">
<link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
 
  <style>
  table thead{ 
    position: sticky;
  position: -webkit-sticky;
  top: 0; /* required */

  }
    /* .table-container{height:80vh; } */
    
    th{font-weight:normal !important}
    td input{width: 100px ;text-align:right}
    td input[type="number"] {
        -moz-appearance: textfield;
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input:disabled {
  cursor: not-allowed; /* Or use default if you want to show no special cursor */
  background-color: #f0f0f0; /* Optional: style the disabled input */
  color: #999;              /* Optional: make text appear dimmed */
}

    </style>
 
    <?php 
        $earning = 0;
        $deduction = 0;
        foreach($orgsalaryComponents as $oc){
            if($oc->type == 'Earning'){
                $earning = $earning + 1;
            } elseif($oc->type == 'Deduction'){
                $deduction = $deduction + 1;
            }
        }
    ?>
<form action="{{ route('insert_payroll_deductions') }}" method="POST">
    @csrf
    @foreach ($payrollData as $data)
        <input type="hidden" name="payroll_id" value="{{ $data['payroll_id'] }}">
        <input type="hidden" name="user_id" value="{{ $data['user_id'] }}">
        <input type="hidden" name="salary_details" value="{{ json_encode($data['salary_details']) }}">
    @endforeach
<div class="m-3">
<h2> <span class="back-btn mx-1" role="button" onclick="history.back()"> &lt; </span>Salary Details</h2>
  <div class="table-container">
  <table id="">
    <thead>
      <tr>
        <th rowspan="2">Employee Name</th>
        
        {{-- Earnings Section --}}
        <th colspan="<?php echo $earning; ?>">Earnings</th>
        
        {{-- Total Earning Section --}}
        <th>Total Earning</th>
        
        {{-- Deductions Section --}}
        <th colspan="<?php echo $deduction; ?>">Deductions</th>
        
        {{-- Total Deduction Section --}}
        <th>Total Deduction</th>
        
        {{-- Net Salary Section --}}
        <th>Net Salary</th>
        <th>-</th>
      </tr>
      <tr>
        {{-- Display Component Names under Earnings --}}
        @foreach ($orgsalaryComponents as $comp)
          @if ($comp->type == 'Earning')
            <th>{{ $comp->name }}</th>
          @endif
        @endforeach
        
        {{-- Total Earning --}}
        <th></th>
        
        {{-- Display Component Names under Deductions --}}
        @foreach ($orgsalaryComponents as $comp)
          @if ($comp->type == 'Deduction')
            <th>{{ $comp->name }}</th>
          @endif
        @endforeach 
        
        {{-- Total Deduction --}}
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($allEmployeeSalary as $employee)
        @php
          $totalEarning = 0;
          $totalDeduction = 0;
        @endphp
        <tr>
          <td>{{ $employee['employee_name'] }}</td>
      
          {{-- Earnings Inputs --}}
          @foreach ($orgsalaryComponents as $comp)
            @if ($comp->type == 'Earning')
              @php
                $compId = $comp->id;
                $isApplicable = isset($employee['salary_details'][$compId]);
                $val = $isApplicable ? $employee['salary_details'][$compId]['value'] : 0;
                if ($isApplicable) $totalEarning += $val;
              @endphp
              <td>
                <input 
                  type="number" 
                  step="0.01" 
                  name="salary[{{ $employee['user_id'] }}][{{ $compId }}]"
                  value="{{ round($val, 2) }}"
                  data-type="Earning"
                  {{ $isApplicable ? '' : 'disabled' }}
                >
              </td>
            @endif
          @endforeach
      
          {{-- Total Earning --}}
          <td class="total-earning">{{ round($totalEarning, 2) }}</td>
      
          {{-- Deduction Inputs --}}
          @foreach ($orgsalaryComponents as $comp)
            @if ($comp->type == 'Deduction')
              @php
                $compId = $comp->id;
                $isApplicable = isset($employee['salary_details'][$compId]);
                $val = $isApplicable ? $employee['salary_details'][$compId]['value'] : 0;
                if ($isApplicable) $totalDeduction += $val;
              @endphp
              <td>
                <input 
                  type="number" 
                  step="0.01" 
                  name="salary[{{ $employee['user_id'] }}][{{ $compId }}]"
                  value="{{ round($val, 2) }}"
                  data-type="Deduction"
                  {{ $isApplicable ? '' : 'disabled' }}
                >
              </td>
            @endif
          @endforeach
      
          {{-- Total Deduction --}}
          <td class="total-deduction">{{ round($totalDeduction) }}</td>
      
          {{-- Net Salary --}}
          <td class="net-salary">{{ round($totalEarning - $totalDeduction) }}</td>
      
        </tr>
      @endforeach
      </tbody>
      
  </table>
  </div>
  <div class="text-end my-4">
  <button type="submit" class="py-2 px-3 ms-auto">Process Salary</button>
      </div>
</div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const rows = document.querySelectorAll('tbody tr');
    
      rows.forEach(row => {
        const inputs = row.querySelectorAll('input[type="number"]');
    
        inputs.forEach(input => {
          input.addEventListener('input', function () {
            updateTotals(row);
          });
        });
    
        updateTotals(row); // Initial calculation
      });
    
      function updateTotals(row) {
        let totalEarning = 0;
        let totalDeduction = 0;
    
        const inputs = row.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
          if (input.disabled) return;
    
          const val = parseFloat(input.value) || 0;
          const type = input.dataset.type;
    
          if (type === 'Earning') {
            totalEarning += val;
          } else if (type === 'Deduction') {
            totalDeduction += val;
          }
        });
    
        // Update DOM
        row.querySelector('.total-earning').textContent = totalEarning.toFixed(2);
        row.querySelector('.total-deduction').textContent = totalDeduction.toFixed(2);
        row.querySelector('.net-salary').textContent = (totalEarning - totalDeduction).toFixed(2);
      }
    });
    </script>
    
   
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Salary Table</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    th, td {
      border: 1px solid #333;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
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

<h2>Salary Details</h2>

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
    
  
</body>
</html>

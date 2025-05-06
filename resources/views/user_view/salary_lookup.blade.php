 
  <title>Salary Table</title>
  

<link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
<!-- <link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}"> -->
<link rel="stylesheet" href="{{ asset('user_end/css/homepage.css') }}">
<link rel="stylesheet" href="{{ asset('user_end/css/employment_data.css') }}">
<link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
 

 
 
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
<form action="{{ route('process_salary_details') }}" method="post">
@csrf
<input type="hidden" name="allemployeeSalaryDetails" value="{{ serialize($allemployeeSalaryDetails) }}">
<input type="hidden" name="allEmployeeSalary" value="{{ serialize($allEmployeeSalary) }}">
<div class="m-3">
<h2> <span class="back-btn fs-2" role="button" onclick="history.back()"> &lt; </span>Salary Details</h2>
  <div class="table-container">
  <table id="">
    <thead>
      <tr>
        <th >Employee Name</th>
        
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
        <th></th>
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
    
    <style>
        .table-container {
            max-width: 100%;
            max-height: 75vh;
            overflow: auto;
            margin: 10px;
            border: 1px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #ddd;
            white-space: nowrap;
        }
     /* First column cells */
        td:first-child,
        thead th:first-child {
            position: sticky;
            left: 0; 
            z-index: 15;
        }

        /* First column header in first row */
        thead tr:first-child th:first-child {
            z-index: 25;
        }

        /* First column header in second row */
        thead tr:nth-child(2) th:first-child {
            z-index: 25;
        }
        th {
            /* background-color: #f8f8f8; */
            position: sticky;
            top: 0;
            z-index: 10;
        }
         /* Second header row */
         thead tr:nth-child(2) th {  
            position: sticky;
            top: 48px;
            /* Height of first header row */
            z-index: 20;
        }


        td:first-child{ position: sticky;
            left: 0;    background:#f5f5f5;
            z-index: 5;}
        th:first-child {
            position: sticky;
            left: 0;
            /* background-color: #f8f8f8; */
            z-index: 5;
        }

        th:first-child {
            z-index: 15;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td:first-child {
            /* background-color: #f0f0f0; */
        }
        thead tr:first-child th::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 1px;
            background-color: #ddd;
        }
    </style>
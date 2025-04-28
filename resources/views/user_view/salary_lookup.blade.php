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
    input[type="number"] {
      width: 70px;
    }
  </style>
</head>
<body>

    @foreach($SalartTempCom as $templateId => $components)

    <h2>Salary Template: {{ $templateId }}</h2>
    <table id="salaryTable_{{ $templateId }}">
      <thead>
        <tr>
          <th rowspan="2">Employee Name</th>
          
          {{-- Earnings Section --}}
          <th colspan="{{ count(array_filter($components, fn($comp) => $comp['type'] == 'Earning')) }}">Earnings</th>
          
          {{-- Total Earning Section --}}
          <th>Total Earning</th>
          
          {{-- Deductions Section --}}
          <th colspan="{{ count(array_filter($components, fn($comp) => $comp['type'] == 'Deduction')) }}">Deductions</th>
          
          {{-- Total Deduction Section --}}
          <th>Total Deduction</th>
          
          {{-- Net Salary Section --}}
          <th>Net Salary</th>
          <th>-</th>
        </tr>
        <tr>
          {{-- Display Component Names under Earnings --}}
          @foreach ($components as $comp)
            @if ($comp['type'] == 'Earning')
              <th>{{ $comp['name'] }}</th>
            @endif
          @endforeach
          
          {{-- Total Earning --}}
          <th></th>
          
          {{-- Display Component Names under Deductions --}}
          @foreach ($components as $comp)
            @if ($comp['type'] == 'Deduction')
              <th>{{ $comp['name'] }}</th>
            @endif
          @endforeach
          
          {{-- Total Deduction --}}
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        {{-- Loop through allEmployeeSalary and display employee data for this template --}}
        @foreach($allEmployeeSalary as $employeeSalary)
          @if($employeeSalary['salary_temp_id'] == $templateId)
            <tr>
              <td>{{ $employeeSalary['employee_name'] }}</td>
              
              {{-- Earnings Columns --}}
              @php $totalEarning = 0; @endphp
              @foreach($components as $comp)
                @if($comp['type'] == 'Earning')
                  @php
                    $value = isset($employeeSalary['salary_details'][$comp['name']]) ? round($employeeSalary['salary_details'][$comp['name']]['value'], 2) : 0;
                    $totalEarning += $value;
                  @endphp
                  <td><input type="number" class="earning" value="{{ $value }}" oninput="calculateFromInput(this)"></td>
                @endif
              @endforeach
              
              <td class="totalEarning">{{ number_format($totalEarning, 2) }}</td>

              {{-- Deductions Columns --}}
              @php $totalDeduction = 0; @endphp
              @foreach($components as $comp)
                @if($comp['type'] == 'Deduction')
                  @php
                    $value = isset($employeeSalary['salary_details'][$comp['name']]) ? round($employeeSalary['salary_details'][$comp['name']]['value'], 2) : 0;
                    $totalDeduction += $value;
                  @endphp
                  <td><input type="number" class="deduction" value="{{ $value }}" oninput="calculateFromInput(this)"></td>
                @endif
              @endforeach
              
              <td class="totalDeduction">{{ number_format($totalDeduction, 2) }}</td>
              <td class="netSalary">{{ number_format($totalEarning - $totalDeduction, 2) }}</td>
              <td>-</td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>

@endforeach

<script>
function calculateFromInput(inputElement) {
  const row = inputElement.closest('tr');
  const earnings = row.querySelectorAll('.earning');
  const deductions = row.querySelectorAll('.deduction');

  let totalEarning = 0;
  earnings.forEach(input => {
    totalEarning += parseFloat(input.value) || 0;
  });

  let totalDeduction = 0;
  deductions.forEach(input => {
    totalDeduction += parseFloat(input.value) || 0;
  });

  const netSalary = totalEarning - totalDeduction;

  row.querySelector('.totalEarning').innerText = totalEarning.toFixed(2);
  row.querySelector('.totalDeduction').innerText = totalDeduction.toFixed(2);
  row.querySelector('.netSalary').innerText = netSalary.toFixed(2);
}
</script>

</body>
</html>

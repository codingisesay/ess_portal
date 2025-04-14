@extends('user_view.header')
@section('content')
<?php
use App\Helpers\SalaryHelper;

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <title>Payroll Dashboard</title>
 <style>
    body {
  font-family: Arial, sans-serif;
  background: #f4f6f8;
  margin: 0;
  padding: 0;
}

.container {
  padding: 30px;
  max-width: 1200px;
  margin: auto;
}

h1 {
  text-align: center;
  margin-bottom: 40px;
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  text-align: center;
}

.card h3 {
  font-size: 16px;
  color: #666;
}

.card p {
  font-size: 24px;
  font-weight: bold;
  margin: 10px 0 0;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

table th, table td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

table th {
  background: #f9fafb;
  font-weight: bold;
}

table tr:hover {
  background: #f1f1f1;
}

    </style>

</head>
<body>
  <div class="container">
    <h1>Payroll Dashboard</h1>
    
    <a href="{{ route('claim_form') }}"><button class="w3-button w3-green">Claim</button></a>
    <br>
    <br>
    <div class="cards">
      <div class="card">
        <h3>Total Employees</h3>
        <p id="employees">0</p>
      </div>
      <div class="card">
        <h3>Payroll Processed</h3>
        <p id="payroll">₹0</p>
      </div>
      <div class="card">
        <h3>This Month Salary</h3>
        <p id="monthlySalary">₹0</p>
      </div>
      <div class="card">
        <h3>Upcoming Increments</h3>
        <p id="increments">0</p>
      </div>
    </div>

    <h2>Recent Payrolls</h2>
    <table>
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department</th>
          <th>Salary</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody id="payrollTable">
        <!-- JS will populate rows here -->
      </tbody>
    </table>
  </div>

  <script>
    // Simulated data
const stats = {
  employees: 145,
  payroll: 1250000,
  monthlySalary: 350000,
  increments: 8
};

const payrollData = [
  { name: "Aman Gupta", dept: "IT", salary: 45000, status: "Paid", date: "Apr 1, 2025" },
  { name: "Nisha Verma", dept: "HR", salary: 40000, status: "Pending", date: "Apr 5, 2025" },
  { name: "Rohit Singh", dept: "Sales", salary: 38000, status: "Paid", date: "Apr 1, 2025" }
];

// Update stats
document.getElementById("employees").textContent = stats.employees;
document.getElementById("payroll").textContent = `₹${stats.payroll.toLocaleString()}`;
document.getElementById("monthlySalary").textContent = `₹${stats.monthlySalary.toLocaleString()}`;
document.getElementById("increments").textContent = stats.increments;

// Populate table
const table = document.getElementById("payrollTable");
payrollData.forEach(row => {
  const tr = document.createElement("tr");
  tr.innerHTML = `
    <td>${row.name}</td>
    <td>${row.dept}</td>
    <td>₹${row.salary.toLocaleString()}</td>
    <td style="color: ${row.status === "Paid" ? "green" : "orange"};">${row.status}</td>
    <td>${row.date}</td>
  `;
  table.appendChild(tr);
});

  </script>
@endsection

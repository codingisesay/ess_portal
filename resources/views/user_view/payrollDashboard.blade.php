<?php
use App\Helpers\SalaryHelper;
$salary = SalaryHelper::calculateSalary(
    60000,  // Monthly Salary
    30,     // Days in Month
    8,      // Working Hours Per Day
    20,     // Present Days
    5,      // Absent Days
    5       // Leave Days
);

echo "Calculated Salary: ₹" . $salary;

?>
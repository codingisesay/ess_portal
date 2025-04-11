<?php

namespace App\Helpers;

class SalaryHelper
{
    /**
     * Calculate salary based on attendance details.
     *
     * @param float $monthlySalary
     * @param int $monthDays
     * @param int $workingHoursPerDay
     * @param int $presentDays
     * @param int $absentDays
     * @param int $leaveDays
     * @return float
     */
    public static function calculateSalary($monthlySalary, $monthDays, $workingHoursPerDay, $presentDays, $absentDays, $leaveDays)
    {
        // Total payable days = present + paid leave
        $payableDays = $presentDays + $leaveDays;

        // Salary per day
        $salaryPerDay = $monthlySalary / $monthDays;

        // Final salary
        $finalSalary = $salaryPerDay * $payableDays;

        return round($finalSalary, 2);
    }
}

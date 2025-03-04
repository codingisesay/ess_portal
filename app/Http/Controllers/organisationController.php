<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class organisationController extends Controller
{
    public function showOrganisation()
    {
        $employees = $this->fetchEmployeeHierarchy();
        $departmentColors = [];
        return view('user_view.organisation', compact('employees', 'departmentColors'));
    }

    private function fetchEmployeeHierarchy()
    {
        $employees = DB::select(
            DB::raw("
                WITH RECURSIVE EmployeeHierarchy AS 
                (
                    SELECT ed.Employee_ID, ed.Employee_Name, ed.Designation, ed.Reporting_Manager, ebd.gender, ed.department, ed.Employee_NO, 1 AS level
                    FROM employee_details ed
                    LEFT JOIN employee_basic_details ebd ON ed.Employee_NO = ebd.Employee_NO
                    WHERE (ed.Reporting_Manager IS NULL OR ed.Reporting_Manager = '') 
                    AND ed.Employment_Status = 'Active'
                    UNION ALL
                    SELECT e.Employee_ID, e.Employee_Name, e.Designation, e.Reporting_Manager, ebd.gender, e.department, e.Employee_NO, eh.level + 1
                    FROM employee_details e
                    LEFT JOIN employee_basic_details ebd ON e.Employee_NO = ebd.Employee_NO
                    INNER JOIN EmployeeHierarchy eh ON e.Reporting_Manager = eh.Employee_ID
                    WHERE e.Employment_Status = 'Active'
                )
                SELECT * FROM EmployeeHierarchy
                ORDER BY level;
            ")
        );

        $emp_tree = [];
        foreach ($employees as $emp) {
            $emp_tree[$emp->Reporting_Manager][] = $emp;
        }

        return $emp_tree;
    }

    private function getProfileImage($employeeNo)
    {
        $profile = DB::table('employee_profiles')
            ->where('Employee_NO', $employeeNo)
            ->value('profile_picture');

        return $profile ? $profile : 'default-profile.jpg';
    }

    private function getDepartmentColor($department, &$departmentColors)
    {
        static $colors = ['#8A3366', '#0E8D4A', '#FFC107', '#E0AFA0', '#2B53C1', '#D53040', '#D9C4EC'];
        static $colorIndex = 0;

        if (!isset($departmentColors[$department])) {
            $departmentColors[$department] = $colors[$colorIndex % count($colors)];
            $colorIndex++;
        }
        return $departmentColors[$department];
    }

    public function displayEmployeeTree($manager, &$departmentColors)
    {
        $emp_tree = $this->fetchEmployeeHierarchy();
        if (isset($emp_tree[$manager])) {
            echo '<ul class="tree">';
            foreach ($emp_tree[$manager] as $emp) {
                $emp_name = htmlspecialchars($emp->Employee_Name ?? '');
                $emp_designation = htmlspecialchars($emp->Designation ?? '');
                $emp_department = htmlspecialchars($emp->department ?? '');
                $emp_employeeNo = htmlspecialchars($emp->Employee_NO);
                $profile_image = $this->getProfileImage($emp_employeeNo);
                $departmentColor = $this->getDepartmentColor($emp_department, $departmentColors);

                echo "<li class='employee' data-emp-id='{$emp->Employee_ID}' data-manager-id='{$emp->Reporting_Manager}'>
                        <div class='employee-box'>
                            <div class='department' style='background-color: $departmentColor;'>$emp_department</div>
                            <div class='profile-container'>
                                <img src='$profile_image' alt='Profile Image' class='profile-img'>
                            </div>
                            <div class='emp-info'>
                                <div class='emp-name'>$emp_name</div>
                                <div class='emp-designation'>$emp_designation</div>
                            </div>
                        </div>";

                $this->displayEmployeeTree($emp->Employee_ID, $departmentColors);
                echo "</li>";
            }
            echo '</ul>';
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // 🔹 Branch Data
        $branches = DB::table('branches as b')
            ->join('organisations as o', 'o.id', '=', 'b.organisation_id')
            ->select(
                'b.id',
                'b.name',
                'o.name as organisation_name',
                DB::raw('(SELECT COUNT(*) 
                          FROM emp_details ed 
                          JOIN users u ON u.id = ed.user_id 
                          WHERE ed.branch_id = b.id) as totalEmployees'),
                DB::raw('(SELECT COUNT(*) 
                          FROM emp_details ed 
                          JOIN users u ON u.id = ed.user_id 
                          WHERE ed.branch_id = b.id AND u.user_status = "Active") as activeCount'),
                DB::raw('(SELECT COUNT(*) 
                          FROM emp_details ed 
                          JOIN users u ON u.id = ed.user_id 
                          WHERE ed.branch_id = b.id AND u.user_status = "Inactive") as inactiveCount'),
                DB::raw('(SELECT COUNT(DISTINCT d.id) 
                          FROM organisation_departments d 
                          WHERE d.organisation_id = b.organisation_id) as departmentsCount')
            )
            ->get();
            // 🔹 Departments → Designations → Active user counts
            $departments = DB::table('organisation_departments as d')
            ->leftJoin('organisation_designations as g', 'g.department_id', '=', 'd.id')
            ->leftJoin('emp_details as ed', function($join) {
                $join->on('ed.department', '=', 'd.id')
                        ->on('ed.designation', '=', 'g.id');
            })
            ->leftJoin('users as u', function($join) {
                $join->on('u.id', '=', 'ed.user_id')
                        ->where('u.user_status', '=', 'Active'); // ✅ Only active users
            })
            ->select(
                'd.id as department_id',
                'd.name as department_name',
                'g.id as designation_id',
                'g.name as designation_name',
                DB::raw('COUNT(DISTINCT u.id) as active_count')
            )
            ->groupBy('d.id', 'd.name', 'g.id', 'g.name')
            ->get()
            ->groupBy('department_name')
            ->map(function ($items, $deptName) {
                return [
                    'name' => $deptName,
                    'items' => $items->map(function ($row) {
                        return [
                            'designation' => $row->designation_name,
                            'active' => $row->active_count,
                        ];
                    })->toArray()
                ];
            })
            ->values();

        // 🔹 Policies grouped by categories
        $policies = DB::table('hr_policy_categories as c')
            ->leftJoin('hr_policies as p', 'p.policy_categorie_id', '=', 'c.id')
            ->select(
                'c.id as category_id',
                'c.name as category_name',
                DB::raw('GROUP_CONCAT(p.policy_title ORDER BY p.policy_title SEPARATOR ",") as policies')
            )
            ->groupBy('c.id', 'c.name')
            ->get()
            ->map(function ($row) {
                return [
                    'category' => $row->category_name,
                    'description' => 'Guidelines for ' . $row->category_name,
                    'items' => $row->policies ? explode(',', $row->policies) : []
                ];
            });

        // ✅ Pass to Blade
        return view('dashboard.superadmin', [
            'branches' => $branches,
            'departments' => $departments,
            'policies' => $policies,
        ]);
    }
}

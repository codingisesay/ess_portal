<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {

        
        // 🔹 Branch Data (organisations with user counts & dept counts)
        $branches = DB::table('organisations as o')
            ->select(
                'o.id',
                'o.name',
                DB::raw('(SELECT COUNT(*) FROM users u WHERE u.organisation_id = o.id) as totalEmployees'),
                DB::raw('(SELECT COUNT(*) FROM users u WHERE u.organisation_id = o.id AND u.user_status = "Active") as activeCount'),
                DB::raw('(SELECT COUNT(*) FROM users u WHERE u.organisation_id = o.id AND u.user_status = "Inactive") as inactiveCount'),
                DB::raw('(SELECT COUNT(*) FROM organisation_departments d WHERE d.organisation_id = o.id) as departmentsCount')
            )
            ->get();
        // 🔹 Departments with their designations
        $departments = DB::table('organisation_departments as d')
            ->leftJoin('organisation_designations as g', 'g.department_id', '=', 'd.id')
            ->select(
                'd.id as department_id',
                'd.name as department_name',
                DB::raw('GROUP_CONCAT(g.name ORDER BY g.name SEPARATOR ",") as designations')
            )
            ->groupBy('d.id', 'd.name')
            ->get()
            ->map(function ($row) {
                return [
                    'name' => $row->department_name,
                    'items' => $row->designations ? explode(',', $row->designations) : []
                ];
            });

        // 🔹 Policies grouped by categories
        $policies = DB::table('hr_policy_categories as c')
            ->leftJoin('hr_policies as p', 'p.policy_categorie_id', '=', 'c.id') // ✅ fixed column name
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

        // Pass data to Blade
        return view('dashboard.superadmin', [
            'branches' => $branches,
            'departments' => $departments,
            'policies' => $policies,
        ]);
    }
}

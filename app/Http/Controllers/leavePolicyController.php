<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class leavePolicyController extends Controller
{
    public function loadPolicyTimeSlot(){
        return view('superadmin_view.create_leave_slot');
    }

    public function loadPolicyType(){
        return view('superadmin_view.create_leave_type');
    }

    public function loadPolicy(){
        return view('superadmin_view.create_leave_policy');
    }

    public function loadEmpPolicy(){
        return view('superadmin_view.employee_policy');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrPolicyViewController extends Controller
{
    public function showHrPolicy()
    {
        return view('user_view.hr_policy');
    }

    public function createHrPolicy()
    {
        return view('superadmin_view.create_hr_policy');
    }

    public function saveHrPolicy(Request $request)
    {
        // Logic to save HR policy
        // ...

        return redirect()->route('create_hr_policy')->with('success', 'HR Policy saved successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrPolicyViewController extends Controller
{
    public function showHrPolicy()
    {
        return view('user_view.hr_policy');
    }
}

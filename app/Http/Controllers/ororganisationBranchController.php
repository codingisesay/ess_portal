<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branche;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ororganisationBranchController extends Controller
{
    public function index(){
        $id = Auth::guard('superadmin')->user()->id;
        $branchs = branche::where('organisation_id', $id)->get();
        return view('superadmin_view.create_branch',compact('branchs'));
    }
}

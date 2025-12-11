<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\View\View;
 
class AdminDashboardController extends Controller
{
    // Show admin dashboard
    public function adminDashboard(): View
    {
        return view('admin_view.dashboard');
    }
}
 
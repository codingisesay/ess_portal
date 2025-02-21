<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homePagecontroller extends Controller
{
    public function showHomepage()
    {
        return view('user_view.homepage');
    }
}

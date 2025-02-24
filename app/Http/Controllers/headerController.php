<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class headerController extends Controller
{
    public function showHeader()
    {
        return view('user_view.header');
    }
}

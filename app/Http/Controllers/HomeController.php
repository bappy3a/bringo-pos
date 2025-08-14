<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        //flash()->success('Message');
        return view('dashboard');
    }
}

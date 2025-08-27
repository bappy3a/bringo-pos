<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function pos(Request $request){
        return view("pos.pos");
    }
}

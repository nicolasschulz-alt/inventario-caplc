<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SistemasController extends Controller
{
    public function sistemas(){

        return view('sistemas.index');
    }
}

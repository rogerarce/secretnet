<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Home extends Controller
{
    public function home()
    {
        return view('home');
    }
}

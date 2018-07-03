<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Navigation extends Controller
{
    public function home()
    {
        return view('recruit.home');
    }

    public function pins()
    {
        return view('recruit.pins');
    }

    public function tree()
    {
        return view('recruit.tree');
    }

    public function recruit(Request $request)
    {
        return view('recruit.recruit');
    }
}

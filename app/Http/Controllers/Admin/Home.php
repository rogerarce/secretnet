<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pins as Pin;

class Home extends Controller
{
    public function home()
    {
        return view('admin.home');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function pins()
    {
        return view('admin.pins', [
            'pins' => Pin::all(),
        ]);
    }
}

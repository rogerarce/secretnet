<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccountType;

class Guest extends Controller
{

    public function register()
    {
        return view('guest.register', ['types' => AccountType::all()]);
    }

    public function login()
    {
        return view('guest.login');
    }
}

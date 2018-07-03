<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pins as Pin;
use App\Models\AccountType;

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
            'account_types' => AccountType::all(),
        ]);
    }
}

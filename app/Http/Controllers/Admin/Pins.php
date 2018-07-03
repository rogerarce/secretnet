<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Pins as Pin;

class Pins extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pin::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pin = new Pin([
            'pin'     => substr(md5(microtime() . rand()), 0, 10),
            'status'  => 'inactive',
            'user_id' => auth()->user()->id,
        ]);

        $pin->save();
    }
}

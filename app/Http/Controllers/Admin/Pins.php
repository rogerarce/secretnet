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
        return response()->json(Pin::all()->load('user', 'assignedTo', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pin = Pin::create([
            'pin'             => substr(md5(microtime() . rand()), 0, 10),
            'status'          => 'inactive',
            'account_type_id' => $request->account_type,
            'assign_to'       => 0,
        ]);

        return Pin::find($pin->id)->load('user', 'assignedTo', 'type');
    }

    /**
     *
     */
    public function checkPin(Request $request)
    {
        $pin = Pin::where('pin', $request->activation_code)->first();
    
        if ($pin->status == 'active') {
            return abor(401, 'Pin is already used');
        }

        return response()->json($pin->load('type'));
    }
}

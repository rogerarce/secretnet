<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Payout as Payouts;

class Payout extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payout = $request->only(['amount', 'note']);
        $payout['user_id'] = auth()->user()->id;
        $payout['status'] = 'pending';
        Payouts::create($payout);

        return redirect()->back();
    }
}

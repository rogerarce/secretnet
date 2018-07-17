<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ConnectedTables as Connected;

use App\Models\Wallet;
use App\Models\Pairing;
use App\Models\Pins as Pin;
use App\Models\Tree;
use App\Models\DirectReferral;

class User extends Controller
{
    use Connected;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Models\User::with('accountType')->where('user_type', 'customer')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pin = Pin::find($request->others['pin']);

        $user = $request->user;
        $user['account_type'] = $pin->type->id;
        $user['password'] = \Hash::make($request->user['password']);
        $user['user_type'] = 'customer';

        $new_user = \App\Models\User::create($user);

        $upline = \App\Models\User::find($request->others['upline_id']);

        $tree = $upline->tree;

        if (!$tree) {
            $tree = Tree::create([
                'position'           => 'left',
                'user_id'            => $request->others['upline_id'],
                'left_user_id'       => $request->others['position'] == 'left' ? $new_user->id : 0,
                'right_user_id'      => $request->others['position'] == 'right' ? $new_user->id : 0,
                'direct_referral_id' => $request->others['directref'],
            ]);
        } else {
            // Save downline to upline position
            if ($request->others['position'] == 'left') {
                $tree->left_user_id = $new_user->id;
                $tree->save();
            } else if ($request->others['position'] == 'right') {
                $tree->right_user_id = $new_user->id;
                $tree->save();
            }
        }

        // Direct Referral
        $direct_referral_user = \App\Models\User::find($request->others['directref']);
        $bonus = $pin->type->direct_referral;
        if ($direct_referral = $direct_referral_user->directReferral) {
            $direct_referral->total_earning += $bonus;
            $direct_referral->save();
        } else {
            DirectReferral::create([
                'user_id'       => $request->others['directref'],
                'total_earning' => $bonus
            ]);
        }

        $max_amount = $this->maxAmount($new_user->accountType->type);
        Wallet::create([
            'max_amount'     => $max_amount,
            'current_amount' => $request->others['profitshare'] == 'max' ? $max_amount : 0,
            'user_id'        => $new_user->id,
        ]); 

        $pin->status = 'active';
        $pin->save();

        return $new_user->load('accountType');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function maxAmount($type)
    {
        switch ($type) {
            case 'silver':
                return 2000;
            case 'gold':
                return 6500;
            case 'platinum':
                return 7500;
            case 'diamond':
                return 10500;
            case 'doublediamond':
                return 15500;
            default:
                return 2000;
        }
    }
}

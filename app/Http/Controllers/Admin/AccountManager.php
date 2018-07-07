<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AdminAccountManager;
use App\Http\Controllers\Controller;
use App\Helpers\PayoutCalculator;

use App\Models\User;
use App\Models\Tree;
use App\Models\Wallet;
use App\Models\Pins as Pin;
use App\Models\Payout;
use Hash;

class AccountManager extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAccountManager $request)
    {
        $pin = Pin::with('type')->where('pin', $request->activation_code)->first();
        $user_data = $request->only(['email', 'first_name', 'last_name', 'address', 'mobile']); 
        $user_data['password'] = Hash::make($request->password);
        $user_data['user_type'] = 'customer';
        $user_data['account_type'] = $pin->type->id;

        $user = User::create($user_data);

        $this->handleTree($request, $user->id);

        $this->handleWallet($user->id, $request->default_profitshare, $pin);

        return redirect()->to('admin/tree');
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

    public function completePayout(Request $request, Payout $payout)
    {
        // calculate deductions
        $user = $payout->user;
        $payout_calculator = new PayoutCalculator($user, $payout);
        $result = $payout_calculator->start();

        $payout->status = 'completed';
        $payout->save();

        return redirect()->back();
    }

    private function handleTree($request, $user_id)
    {
        // Create Tree
        $tree = Tree::where('user_id', $request->upline_id)->first();
        $position = $request->position . '_user_id';

        if ($tree) {
            $data = [];
            $data[$position] = $user_id;
            $tree->update($data);
        } else {
            $data = [
                'user_id'            => $request->upline_id,
                'position'           => $request->position,
                'direct_referral_id' => $request->direct_referral_id,
            ];
            $data[$position] = $user_id;
            $tree = Tree::create($data);
        }

        return $tree;
    }

    private function handleWallet($user_id, $amount, $pin)
    {
        Wallet::create([
            'max_amount'     => $this->getMaxAmount($pin->type->type),
            'current_amount' => $amount,
            'user_id'        => $user_id
        ]);
    }

    private function getMaxAmount($type)
    {
        switch ($type->type) {
            case "silver":
                return 2000;
            case "gold":
                return 6500;
            case "platinum":
                return 7500;
            case "diamond":
                return 10500;
            case "doublediamond":
                return 15500;
            default:
                return 2000;
        }
    }
}

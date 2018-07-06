<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Helpers\ProfitShare;
use App\Http\Requests\RecruitRegister as Recruit;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Tree;
use App\Models\Pins as Pin;
use App\Models\Wallet;

use Auth;

class AccountManager extends Controller
{
    private $user_info = ['email','first_name','last_name','address','mobile'];
    private $tree_info = ['position', 'direct_referral_id'];

    /**
     *
     */
    public function register(Recruit $request)
    {
        if (!$this->_checkPin($request)) {
            return redirect()->back()->withErrors(['Invalid Activation Code!']);
        }

        $pin = Pin::with('type')->where('pin', $request->activation_code)->first();

        $user_data = $request->except(['activation_code']);
        $user_data['password'] = \Hash::make($request->password);
        $user_data['account_type'] = $pin->type->id;
        $user_data['user_type'] = 'customer';

        $user = User::create($user_data);

        $pin->update(['status' => 'active']);

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            return redirect()->intended('user');
        }
    }

    /**
     *
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();
            if ($user->user_type == 'admin') {
                return redirect()->intended('admin');
            } else {
                return redirect()->intended('user');
            }
        }
    }

    /**
     * @Todo Calculate Direct Referral
     * @Todo Calculate Profit Sharing
     * @Todo Calculate Pairing Bonus 
     */
    public function registerRecruit(Recruit $request)
    {
        $pin = $this->_getActivationCode($request->activation_code);

        // Starts profit sharing
        $this->profitShare($pin->type);

        // Create User
        $user_data = $this->_getUserData($request, $pin);
        $user = User::create($user_data);

        // Create Tree Connection
        $tree_data = $this->_getTreeData($request, $user);

        $current_tree = Tree::where('user_id', $request->upline_id)->first();

        if ($current_tree) {
            $position = $request->position . '_user_id';
            $fields = [];
            $fields[$position] = $user->id;
            $current_tree->update($fields);
        } else {
            $tree = Tree::create($tree_data);
        }

        Wallet::create([
            "max_amount"     => $this->getMaxAmount($pin->type),
            "current_amount" => 0,
            "user_id"        => $user->id,
        ]);

        // Activate Pin
        $pin->update(['status' => 'active']);

        return redirect()->route('recruithome');
    }

    /**
     *
     */
    private function _getActivationCode($activation_code)
    {
        return Pin::with('type')->where('pin', $activation_code)->first();
    }

    /**
     *
     */
    private function _getUserData($request, $pin)
    {
        $user_data = $request->only($this->user_info);
        $user_data['password'] = \Hash::make($request->password);
        $user_data['user_type'] = 'customer'; 
        $user_data['account_type'] = $pin->type->id; 

        return $user_data;
    }

    /**
     * 
     */
    private function _getTreeData($request, $user)
    {
        $tree_data = $request->only($this->tree_info);
        $position = $request->position . '_user_id';
        $tree_data['user_id'] = $request->upline_id;
        $tree_data[$position] = $user->id;

        return $tree_data;
    }

    /**
     *
     */
    private function _checkPin(Request $request)
    {
        $pin = Pin::where('pin', $request->activation_code)->first();

        return $pin && $pin->status == 'inactive';
    }

    /**
     * Initiates Profit Sharing;
     *
     * @param Object
     */
    private function profitShare($account_type)
    {
        $profitshare = new ProfitShare($account_type);
        $profitshare->start();
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

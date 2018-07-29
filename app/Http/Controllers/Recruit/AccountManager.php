<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Helpers\Pairing;
use App\Helpers\ProfitShare;
use App\Http\Requests\RecruitRegister as Recruit;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Tree;
use App\Models\Pins as Pin;
use App\Models\Wallet;
use App\Models\DirectReferral;

use App\Traits\ConnectedTables;
use App\Traits\Logger;;

use Auth;
use Toastr;

class AccountManager extends Controller
{
    use ConnectedTables;
    use Logger;

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

        $pin = Pin::with('type', 'upline.tree')->where('pin', $request->activation_code)->first();

        $user_data = $request->except(['activation_code']);
        $user_data['password'] = \Hash::make($request->password);
        $user_data['account_type'] = $pin->type->id;
        $user_data['user_type'] = 'customer';

        if ($pin->upline->tree && $pin->upline->tree->left_user_id && $pin->upline->tree->right_user_id) {
            return Toastr::error('Invalid activation key please contact admin for support');
        }

        if ($pin->upline->user_type !== 'admin') {
            $this->profitShare($pin->type);
        }

        $user = User::create($user_data);

        $pin->update(['status' => 'active']);

        $this->handleTree($user->id, $pin->upline_user);

        $credentials = $request->only(['email', 'password']);
            
        $this->createInitials($user);

        if ($pin->upline->user_type !== 'admin') {
            $this->directReferralBonus($pin->upline->id, $pin);
        }

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
                $pairing = new Pairing($user);
                $pairing->start();
                return redirect()->intended('user');
            }
        } else {
            \Toastr::error('Email or password is incorrect', 'Failed Login');
            return redirect()->back();
        }
    }

    /**
     * @Todo Calculate Direct Referral
     * @Todo Calculate Profit Sharing
     * @Todo Calculate Pairing Bonus 
     */
    public function registerRecruit(Recruit $request)
    {
        if (!$this->_checkPin($request)) {
            Toastr::warning('Access Token is invalid or is used by another user', 'Invalid Key');
            return redirect()->back();
        }

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

        $this->createInitials($user);

        // Activate Pin
        $pin->update(['status' => 'active']);

        // calculates pairing bonus
        $this->pairingBonus();

        $this->directReferralBonus($request->direct_referral_id, $pin);

        return redirect()->route('recruithome');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();
        if (!empty($request->password)) {
            $data['password'] = \Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->update();

        \Toastr::success('Updated profile!', 'Update');
        return redirect()->back();
    }

    public function upgradeAccount(Request $request)
    {
        $pin = Pin::where('pin', $request->pin)->first();
        $user = auth()->user();
        $wallet = $user->wallet;
        
        if ($pin) {
            if ($pin->type->type == $user->accountType->type) {
                Toastr::error('Activation Code - Account Type is the same as your current Account Type');
                return redirect()->back();
            }

            // Increase Pairing Bonus
            $pin_type = $pin->type;
            $wallet->max_amount = $this->getMaxAmount($pin_type); 
            $wallet->save();

            $referral = User::find($request->direct_referral);

            // Direct Referral Bonus
            if ($referral && $referral->directReferral) {
                $current_bonus = $user->accountType->direct_referral;
                $direct_referral = $referral->directReferral;
                $direct_referral_bonus = ($pin_type->direct_referral - $current_bonus);
                $direct_referral->total_earning = $direct_referral_bonus;
                $direct_referral->save();

                $this->profit($direct_referral_bonus, 'Direct Referral', $request->direct_referral);
            }


            // Account Upgrade
            $user->account_type = $pin_type->id;
            $user->save();

            $pin->status = 'active';
            $pin->save();
            Toastr::success('Account Upgrade Success');

            return redirect()->back();
        }

        Toastr::error('Activation code not found');

        return redirect()->back();
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
    
    /**
     * Calculates the pairing bonus
     * if applicable
     *
     * @return Void
     */
    private function pairingBonus()
    {
        $user = auth()->user();
        $pairing_calculator = new Pairing($user);
        $pairing_calculator->start();
    }

    private function directReferralBonus($user_id, $pin)
    {
        $user = User::find($user_id);
        $bonus = $pin->type->direct_referral;
        if ($direct_referral = $user->directReferral) {
            $direct_referral->total_earning += $bonus;
            $direct_referral->save();
        } else {
            DirectReferral::create([
                'user_id'       => $user->id,
                'total_earning' => $bonus
            ]);
        }

        $this->profit($bonus, 'Direct Referral', $user_id);
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

    private function handleTree($user_id, $upline_id)
    {
        $tree = Tree::where('user_id', $upline_id)->first();

        if ($tree) {
            if (!$tree->left_user_id) {
                $tree->left_user_id = $user_id;
                $tree->save();
            } else if (!$tree->right_user_id) {
                $tree->right_user_id = $user_id;
                $tree->save();
            } else {
                Toasts::error('Invalid Activation key please contact admin');

                return false;
            }
        } else {
            $tree = Tree::create([
                'position'           => 'left',
                'left_user_id'       => $user_id,
                'right_user_id'      => null,
                'direct_referral_id' => $upline_id,
                'user_id'            => $upline_id
            ]);
        }

        return $tree;
    }
}

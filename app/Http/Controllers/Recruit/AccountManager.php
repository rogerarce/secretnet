<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Requests\RecruitRegister as Recruit;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Pins as Pin;

use Auth;

class AccountManager extends Controller
{
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
            return redirect()->intended('user/dashboard');
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

    private function _checkPin(Request $request)
    {
        $pin = Pin::where('pin', $request->activation_code)->first();

        return $pin && $pin->status == 'inactive';
    }
}

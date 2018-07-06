<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ConnectedUsers;
use App\Helpers\TotalIncome;
use App\Traits\TreeBuilder;
use Auth;

class Navigation extends Controller
{
    use TreeBuilder;

    public function home()
    {
        $income = new TotalIncome(auth()->user());
        $income_list = [
            'pairing' => $income->pairingBonus(),
            'package' => money_format("%.2n", $income->packageBonus()),
            'direct_referral' => money_format("%.2n", $income->directReferralBonus()),
            'total_income' => money_format("%.2n", $income->totalIncome())
        ];
        return view('recruit.home', ['income_list' => $income_list]);
    }

    public function pins()
    {
        return view('recruit.pins');
    }

    public function tree()
    {
        $user = Auth::user()->load('tree','tree.left.tree.left','tree.left.tree.right','tree.right.tree.left','tree.right.tree.right');
        $result = $this->buildTree($user);
        return view('recruit.tree', ['user' => $user, 'tree' => $result]);
    }

    public function recruit(Request $request)
    {
        $user = Auth::user()->load('tree','tree.left.tree','tree.right.tree');
        $connection = new ConnectedUsers($user->tree);
        $result = $connection->start(); 
        $result[] = auth()->user();
        return view('recruit.recruit', ['users' => $result]);
    }
}

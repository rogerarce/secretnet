<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ConnectedUsers;
use App\Helpers\TotalIncome;
use App\Traits\TreeBuilder;
use App\Traits\BreadCrumb;
use App\Models\Log as Logger;

use App\Models\User;

use Auth;

class Navigation extends Controller
{
    use TreeBuilder;
    use BreadCrumb;

    public function home()
    {
        $income = new TotalIncome(auth()->user());
        $logs = Logger::where('user_id', auth()->user()->id)->get();
        $income_list = [
            'pairing' => $income->pairingBonus(),
            'package' => money_format("%.2n", $income->packageBonus()),
            'direct_referral' => money_format("%.2n", $income->directReferralBonus()),
            'total_income' => money_format("%.2n", $income->totalIncome())
        ];
        return view('recruit.home', ['income_list' => $income_list, 'sys_logs' => $logs]);
    }

    public function pins()
    {
        return view('recruit.pins');
    }

    public function tree(Request $request)
    {
        $user = $request->user_id ? User::find($request->user_id) : Auth::user();
        $user = $this->getTree($user);
        $result = $this->buildTree($user);
        $breadcrumb = $this->breadCrumbHandler($user->id);
        return view('recruit.tree', ['user' => $user, 'tree' => $result, 'breadcrumb' => $breadcrumb]);
    }

    public function recruit(Request $request)
    {
        $user = Auth::user()->load('tree','tree.left.tree','tree.right.tree');
        $connection = new ConnectedUsers($user->tree);
        $result = $connection->start(); 
        $result[] = auth()->user();
        return view('recruit.recruit', ['users' => $result]);
    }

    protected function getTree($user)
    {
        return $user->load('tree','tree.left.tree.left','tree.left.tree.right','tree.right.tree.left','tree.right.tree.right');
    }
}

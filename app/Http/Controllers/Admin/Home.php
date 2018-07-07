<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ConnectedUsers;

use App\Models\Pins as Pin;
use App\Models\AccountType;
use App\Models\User;
use App\Models\Log as Logger;
use App\Models\Payout;

use App\Traits\TreeBuilder;
use App\Traits\BreadCrumb;
use Auth;

class Home extends Controller
{
    use TreeBuilder;
    use BreadCrumb;

    public function home()
    {
        $users = User::where('user_type','customer')->get();
        $products = Pin::where('status','active')->get();
        $sys_logs = Logger::all()->load('user.accountType');
        return view('admin.home', [
            'users' => $users,
            'sales' => $this->getTotalSales($products),
            'sys_logs' => $sys_logs,
        ]);
    }

    public function users()
    {
        $users = User::where('user_type','customer')->get();
        return view('admin.users', ['users' => $users]);
    }

    public function pins()
    {
        return view('admin.pins', [
            'account_types' => AccountType::all(),
            'users'         => User::all(),
        ]);
    }

    public function sales()
    {
        $products = Pin::where('status','active')->get();
        return view('admin.sales', [
            'products' => $products,
            'total_sales' => $this->getTotalSales($products),
        ]);
    }

    public function tree(Request $request)
    {
        $user = $request->user_id ? User::find($request->user_id)->load('accountType') : Auth::user()->load('accountType');
        $user = $this->getTree($user);
        $result = $this->buildTree($user);
        $breadcrumb = $this->breadCrumbHandler($user->id);
        return view('admin.tree', ['tree' => $result, 'breadcrumb' => $breadcrumb]);
    }

    public function register()
    {
        $user = Auth::user()->load('tree','tree.left.tree','tree.right.tree');
        $connection = new ConnectedUsers($user->tree);
        $result = $connection->start(); 
        $result[] = auth()->user();
        return view('admin.register', ['users' => $result]);
    }

    public function payout()
    {
        return view('admin.payout', ['payouts' => Payout::orderBy('status')->get()]);
    }

    private function getTotalSales($products)
    {
        $prices = [];
        foreach ($products as $product) {
            $prices[] = (int)$product->type->price;
        }

        return money_format("%.2n", array_sum($prices));
    }

    protected function getTree($user)
    {
        return $user->load('tree','tree.left.tree.left','tree.left.tree.right','tree.right.tree.left','tree.right.tree.right');
    }
}

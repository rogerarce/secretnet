<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pins as Pin;
use App\Models\AccountType;
use App\Models\User;

class Home extends Controller
{
    public function home()
    {
        $users = User::where('user_type','customer')->get();
        $products = Pin::where('status','active')->get();
        return view('admin.home', [
            'users' => $users,
            'sales' => $this->getTotalSales($products),
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

    private function getTotalSales($products)
    {
        $prices = [];
        foreach ($products as $product) {
            $prices[] = (int)$product->type->price;
        }

        return money_format("%.2n", array_sum($prices));
    }
}

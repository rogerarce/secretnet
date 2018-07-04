<?php

namespace App\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ConnectedUsers;
use Auth;

class Navigation extends Controller
{
    public function home()
    {
        return view('recruit.home');
    }

    public function pins()
    {
        return view('recruit.pins');
    }

    public function tree()
    {
        $user = Auth::user()->load('tree','tree.left.tree.left','tree.left.tree.right','tree.right.tree.left','tree.right.tree.right');
        return view('recruit.tree', ['user' => $user]);
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

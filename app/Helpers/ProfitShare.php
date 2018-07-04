<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Log as Logs;
use App\Models\Wallet;

class ProfitShare
{
    protected $account_type;
    protected $users;

    public function __construct($account_type)
    {
        $this->account_type = $account_type;
        $this->users = User::where('user_type', 'customer')->get();
    }
    
    public function start()
    {
        $type = $this->account_type;

        $users = $this->users;
            
        $total_division = 0;

        foreach ($users as $user) {
            $total_division += $user->accountType->shares; 
            echo $user->email . ' ' . $user->fullName() . '<br>';
        }

        $profit_share_amount = $type->price * .10;
        
        $amount_per_share = round((float)$profit_share_amount / $total_division, 2);

        $this->startProfitShare($amount_per_share);
    }

    /**
     * @Todo Check if wallet has max amount;
     */
    private function startProfitShare($amount_per_share)
    {
        foreach ($this->users as $user) {
            $shares = $user->accountType->shares;
            $total_amount = (float)$amount_per_share * (int)$shares;
            $wallet = $user->wallet;
            $wallet->current_amount += $total_amount;
            $wallet->save();
                
            Logs::create([
                'user_id' => $user->id,
                'action'  => 'profit',
                'message' => $total_amount,
            ]);
        }
    }
}

<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Log as Logs;
use App\Models\Wallet;
use App\Traits\Logger;

class ProfitShare
{
    use Logger;

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
            if ($wallet) {
                $wallet_total = $wallet->current_amount + $wallet->deducted;
                if ($wallet_total < $wallet->max_amount) {
                    $wallet->current_amount += $total_amount;
                    $wallet->save();
                    $this->profit($total_amount, 'Profit Sharing Bonus', $user->id);
                }
            } else {
                $this->createWallet($user, $total_amount);
                $this->profit($total_amount, 'Profit Sharing Bonus', $user->id);
            }

        }
    }

    private function createWallet($user, $amount)
    {
        Wallet::create([
            'max_amount'     => $this->maxAmount($user->accountType->type),
            'current_amount' => $amount,
            'user_id'        => $user->id,
        ]); 
    }

    private function maxAmount($type)
    {
        switch ($type) {
            case 'silver':
                return 2000;
            case 'gold':
                return 6500;
            case 'platinum':
                return 7500;
            case 'diamond':
                return 10500;
            case 'doublediamond':
                return 15500;
            default:
                return 2000;
        }
    }
}

<?php

namespace App\Traits;

use App\Models\Wallet;
use App\Models\Pairing;
use App\Models\DirectReferral;

trait ConnectedTables
{
    protected function createInitials($user)
    {
        $this->createWallet($user);
        $this->createDirectReferral($user);
        $this->createPairing($user);
    }

    protected function createWallet($user)
    {
        Wallet::create([
            'max_amount'     => $this->maxAmount($user->accountType->type),
            'current_amount' => 0,
            'user_id'        => $user->id,
        ]); 
    }

    private function createPairing($user)
    {
        Pairing::create([
            'user_id'            => $user->id ,
            'match_count'        => 0,
            'total_earned'       => 0,
            'todays_match_count' => 0,
        ]);
    }

    private function createDirectReferral($user)
    {
        DirectReferral::create([
            'user_id'       => $user->id,
            'total_earning' => 0,
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

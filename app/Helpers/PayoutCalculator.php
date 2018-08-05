<?php

namespace App\Helpers;

use App\Helpers\TotalIncome;

class PayoutCalculator
{
    private $user;
    private $payout;
    private $incomecalc;

    public function __construct($user, $payout)
    {
        $this->incomecalc = new TotalIncome($user);
        $this->user = $user;
        $this->payout = $payout;
    }

    public function start()
    {
        $total = $this->incomecalc->totalIncome();
        
        if ($this->payout->amount <= $total) {
            $amount = $this->payout->amount;
            $pairing_result = $this->checkPairing($amount);
            $direct_referral = $pairing_result == 'completed' ? $pairing_result : $this->checkDirectRef($amount, $pairing_result);
            $profit_sharing = $direct_referral == 'completed' ? $direct_referral : $this->checkProfitSharing($amount, $direct_referral);

            return $profit_sharing == 'completed';
        }
    }

    private function checkPairing($amount)
    {
        $pairing = $this->user->pairing;
        $remaining_balance = $pairing->total_earned;
        
        if ($remaining_balance >= $amount) {
            $balance = $remaining_balance - $amount;
            $pairing->total_earned = $balance;
            $pairing->save();

            return 'completed';
        } else {
            return $pairing->total_earned;
        }
    }

    private function checkDirectRef($amount, $add)
    {
        $direct_referral = $this->user->directReferral;
        $remaining_balance = $direct_referral->total_earning;

        // Add balance on DR & PB
        $sum_diff_pair = $remaining_balance + $add;
        $pairing = $this->user->pairing;

        // Check if DirectReferral balance is enough
        if ($remaining_balance >= $amount) {
            $balance = $remaining_balance - $amount;
            $direct_referral->total_earning = $balance;
            $direct_referral->save();
        } else if ($sum_diff_pair >= $amount) { // Check if sum of DR & PB is enough
            $balance = $sum_diff_pair - $amount;

            // Resets pairing balance to 0;
            $pairing->total_earned = 0;
            $pairing->save();

            // Puts the balance to Direct Referral
            $direct_referral->total_earning = $balance;
            $direct_referral->save();

            return 'completed';
        } else { // return the sum of DR & PB
            return $sum_diff_pair;
        }
    }

    private function checkProfitSharing($amount, $add)
    {
        $pairing = $this->user->pairing;
        $direct_referral = $this->user->directReferral;
        $profit_sharing = $this->user->wallet;

        // Profit share balance
        $remaining_balance = $profit_sharing->current_amount;

        // Add Balance of DR & PB & PS
        $sum_dirr_pair_profit = $remaining_balance + $add;

        if ($remaining_balance >= $amount) {
            $balance = $remaining_balance - $amount;

            $profit_sharing->current_amount = $balance;
            // need to save the deducted amount
            $profit_sharing->save(); 
        } else if ($sum_dirr_pair_profit >= $amount) {
            $balance = $sum_dirr_pair_profit - $amount;
            
            $pairing->total_earned = 0;
            $pairing->save();

            $direct_referral->total_earning = 0;
            $direct_referral->save();

            $profit_sharing->current_amount = $balance;
            $profit_sharing->deducted = abs($remaining_balance - $balance);
            $profit_sharing->save();

            return 'completed';
        } else {
            return false;
        }
    }
}

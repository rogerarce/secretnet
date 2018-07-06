<?php 

namespace App\Helpers;

class TotalIncome
{
    private function $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function totalIncome()
    {

    }

    /**
     *
     */
    public function pairingBonus()
    {
        $pairing = $this->user->pairing;
        return $pairing->total_earned;
    }

    /**
     *
     */
    public function packageBonus()
    {
        $package = $this->user->wallet;
        return $package->current_amount;
    }

    /**
     *
     */
    public function directReferralBonus()
    {

    }
}

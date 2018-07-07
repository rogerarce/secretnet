<?php 

namespace App\Helpers;

class TotalIncome
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function totalIncome()
    {
        $pairing = $this->pairingBonus();
        $package = $this->packageBonus();
        $direct_referral = $this->directReferralBonus();

        return $total = (float)$pairing + (float)$package + (float)$direct_referral;
    }

    /**
     *
     */
    public function pairingBonus()
    {
        $pairing = $this->user->pairing;
        if ($pairing) {
            return $pairing->total_earned;
        }
    }

    /**
     *
     */
    public function packageBonus()
    {
        $package = $this->user->wallet;
        if ($package) {
            return $package->current_amount;
        }
    }

    /**
     *
     */
    public function directReferralBonus()
    {
        $direct_referral = $this->user->directReferral;
        if ($direct_referral) {
            return $direct_referral->total_earning;
        }
    }
}

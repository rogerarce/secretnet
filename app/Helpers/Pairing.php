<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;

use App\Traits\Logger;

class Pairing
{
    use Logger;

    protected $points_left;
    protected $points_right;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function start()
    {
        $user = $this->user;
        $tree = $user->tree;
        $pairing = $user->pairing;
        $account_type = $user->accountType;

        //
        $this->checkIfStale($pairing);

        //
        $left_user = $tree->left;
        $right_user = $tree->right;

        //
        $left_points = $this->collectLeftPoints($left_user);
        $right_points = $this->collectRightPoints($right_user);

        $match_counts = min($left_points, $right_points);

        if ($pairing) {
            $unused_pairs = $match_counts - $pairing->match_count;
        }

        if ($pairing->todays_match_count == $account_type->daily_pairs) {
            return false;
        }

        $daily_limit = $account_type->daily_pairs;
        $current_match_count = $pairing->todays_match_count;
        $match_count = $unused_pairs;//

        $pairing_count = abs($current_match_count - $daily_limit);
        $allowed_pairing = min($pairing_count, $match_count);
    
        // calculate bonus
        $bonus = (150 * $allowed_pairing);

        $pairing->match_count += $allowed_pairing;
        $pairing->total_earned += $bonus;
        $pairing->todays_match_count += $allowed_pairing;
        $pairing->save();

        if ($bonus > 0) {
            $this->profit($bonus, 'Pairing Bonus', $user->id);
        }
    }

    private function collectLeftPoints($user)
    {
        if (!$user) return;

        $this->points_left += $user->accountType->shares;

        if ($user->tree) {
            $this->collectLeftPoints($user->tree->left);
            $this->collectLeftPoints($user->tree->right);
        }

        return $this->points_left;
    }

    private function collectRightPoints($user)
    {
        if (!$user) return;

        $this->points_right += $user->accountType->shares;

        if ($user->tree) {
            $this->collectRightPoints($user->tree->left);
            $this->collectRightPoints($user->tree->right);
        }

        return $this->points_right;
    }

    private function checkIfStale($pairing)
    {
        if ($pairing) {
            if (!$pairing->updated_at->isToday()) {
                $pairing->todays_match_count = 0;
                $pairing->save();
            }
        }
    }
}

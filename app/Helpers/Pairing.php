<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Pairing as Pairings;
use Carbon\Carbon;

use App\Traits\Logger;

class Pairing
{
    use Logger;

    protected $points_left = [];
    protected $points_right = [];
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

        if (!$pairing) {
            $pairing = Pairings::create([
                'user_id'            => $user->id,
                'match_count'        => 0,
                'total_earned'       => 0,
                'todays_match_count' => 0
            ]);
        }

        $account_type = $user->accountType;

        //
        $this->checkIfStale($pairing);

        //
        if (!$tree) {
            return false;
        }

        $left_user = $tree->left;
        $right_user = $tree->right;

        //
        $this->collectLeftPoints($left_user);
        $this->collectRightPoints($right_user);

        $left_points = array_sum($this->points_left);
        $right_points = array_sum($this->points_right);

        $match_counts = min($left_points, $right_points);

        if ($pairing) {
            $unused_pairs = $match_counts - $pairing->match_count;
        }

        if ($pairing && $pairing->todays_match_count == $account_type->daily_pairs) {
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

        if ($bonus) {
            $this->profit($bonus, 'Pairing Bonus', $user->id);
        }
    }

    private function collectLeftPoints($user)
    {
        if (!$user) return;

        $this->points_left[] = $user->accountType->shares;

        if ($user->tree) {
            $this->collectLeftPoints($user->tree->left);
            $this->collectLeftPoints($user->tree->right);
        }

        return $this->points_left;
    }

    private function collectRightPoints($user)
    {
        if (!$user) return;

        $this->points_right[] = $user->accountType->shares;

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

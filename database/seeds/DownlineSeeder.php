<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Tree;
use App\Models\AccountType;
use App\Models\Wallet;
use App\Models\Pairing;
use App\Models\DirectReferral;

class DownlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_type_id = AccountType::find(1)->id;
        $upline = User::find(1);

        $user = User::create([
            'first_name'   => 'Ryan',
            'last_name'    => 'Negradas',
            'email'        => 'ryan@gmail.com',
            'address'      => 'Tacloban',
            'account_type' => $account_type_id,
            'user_type'    => 'customer',
            'mobile'       => '0000000000',
            'password'     => \Hash::make('123456789')
        ]);
        
        $upline_admin = Tree::create([
            'position'           => 'left',
            'user_id'            => $upline->id,
            'left_user_id'       => $user->id,
            'right_user_id'      => null,
            'direct_referral_id' => $upline->id,
        ]);

        $pairing = Pairing::create([
            'user_id'            => $user->id,
            'match_count'        => 0,
            'total_earned'       => 0,
            'todays_match_count' => 0
        ]);

        $direct_referral = DirectReferral::create([
            'user_id'       => $user->id,
            'total_earning' => 0,
        ]);

        $wallet = Wallet::create([
            'max_amount'     => 2000,
            'current_amount' => 0,
            'user_id'        => $user->id,
        ]); 
    }
}

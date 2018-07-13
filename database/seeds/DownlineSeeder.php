<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Tree;
use App\Models\AccountType;

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
    }
}

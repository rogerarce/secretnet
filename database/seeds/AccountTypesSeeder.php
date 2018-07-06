<?php

use Illuminate\Database\Seeder;
use App\Models\AccountType as Type;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::updateOrcreate([
            'type'            => 'silver',
        ],[
            'price'           => '1500',
            'pairing_bonus'   => '150',
            'direct_referral' => '150',
            'daily_pairs'     => '10',
            'shares'          => 1,
        ]);
        Type::updateOrCreate([
            'type'            => 'gold',
        ],[
            'price'           => '4500',
            'pairing_bonus'   => '450',
            'direct_referral' => '450',
            'daily_pairs'     => '15',
            'shares'          => 3,
        ]);
        Type::updateOrCreate([
            'type'            => 'platinum',
        ],[
            'price'           => '7500',
            'pairing_bonus'   => '750',
            'direct_referral' => '750',
            'daily_pairs'     => '20',
            'shares'          => 5,
        ]);
        Type::updateOrCreate([
            'type'            => 'diamond',
        ],[
            'price'           => '10500',
            'pairing_bonus'   => '1050',
            'direct_referral' => '1050',
            'daily_pairs'     => '25',
            'shares'          => 7,
        ]);
        Type::updateOrCreate([
            'type'            => 'doublediamond',
        ],[
            'price'           => '15000',
            'pairing_bonus'   => '1500',
            'direct_referral' => '1500',
            'daily_pairs'     => '30',
            'shares'          => 7,
        ]);
    }
}

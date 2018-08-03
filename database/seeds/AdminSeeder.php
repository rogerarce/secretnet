<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::firstOrCreate([
            'email' => 'estradanoeljr22@gmail.com',
        ], [
            'first_name' => 'Noel',
            'last_name' => 'Estrada',
            'password' => bcrypt(123456789),
            'user_type' => 'admin',
            'address' => 'Mandaluyong city',
            'mobile' => '09456721856',
            'account_type' => 5,
        ]);
    }
}

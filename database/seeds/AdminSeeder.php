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
            'email' => env('ADMIN_EMAIL') 
        ], [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'user_type' => 'admin',
        ]);
    }
}

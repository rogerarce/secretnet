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
            'email' => 'admin@admin.com',
        ], [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'password' => bcrypt(1),
            'user_type' => 'admin',
            'mobile' => '0912313123',
        ]);
    }
}

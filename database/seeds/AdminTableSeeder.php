<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => "Santiago",
            'email' => "topephysics@gmail.com",
            'password' => bcrypt('s@nt1@g0251317'),
            'first_name' => "Temitope",
            'last_name' => "Ilesanmi",
            'role' => 'super'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['name' => 'Cashier', 'email' => 'cashier@email.com', 'password' => Hash::make('passwordcashier'), 'role_id' => 1],
            ['name' => 'Supervisor', 'email' => 'supervisor@email.com', 'password' => Hash::make('passwordsupervisor'), 'role_id' => 2],
            ['name' => 'Staff', 'email' => 'staff@email.com', 'password' => Hash::make('passwordstaff'), 'role_id' => 3],
        ]);
    }
}

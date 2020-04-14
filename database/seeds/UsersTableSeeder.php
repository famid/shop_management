<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Mr. Admin',
            'email' => 'admin@email.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345'),
            'role'=>'Admin'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'username' => 'officer',
                'email' => 'officer@demo.com',
                'type' => 'officer',
                'password' => bcrypt('password'),
            ],
            [
                'username' => 'customer',
                'email' => 'customer@demo.com',
                'type' => 'customer',
                'password' => bcrypt('password'),
            ],
            [
                'username' => 'customer_baru',
                'email' => 'customer_baru@demo.com',
                'type' => 'customer',
                'password' => bcrypt('password'),
            ],
        ]);

        DB::table('customers')->delete();
        DB::table('customers')->insert([
            [
                'user_id' => \App\User::where('username','customer')->first()->id,
                'account_number' => 123456,
                'name' => 'officer',
                'balance' => 0,
            ],
            [
                'user_id' => \App\User::where('username','customer_baru')->first()->id,
                'account_number' => 654321,
                'name' => 'Customer Baru',
                'balance' => 0,
            ],
        ]);
    }
}

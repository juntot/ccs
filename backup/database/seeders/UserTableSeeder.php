<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Hash;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_tbl')->delete();
        DB::table('user_tbl')->insert(
            [
                [
                    'userId' => 'admin',
                    'password' => Hash::make('1234'),
                    'fullName' => Str::random(10),
                    'role' => 1,
                    'status' => 1
                ],
                [
                    'userId' => 'sudo',
                    'password' => Hash::make('1234'),
                    'fullName' => Str::random(10),
                    'role' => 1,
                    'status' => 1
                ],
                [
                    'userId' => 'encoder',
                    'password' => Hash::make('1234'),
                    'fullName' => Str::random(10),
                    'role' => 2,
                    'status' => 1
                ],
                [
                    'userId' => 'scanner',
                    'password' => Hash::make('1234'),
                    'fullName' => Str::random(10),
                    'role' => 3,
                    'status' => 1
                ],
            ]
    );
    }
}


// php artisan db:seed --class=UserTableSeeder
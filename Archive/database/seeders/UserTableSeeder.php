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
        DB::table('user_tbl')->insert([
            'email' => 'admin@admin.com',
            'password' => Hash::make('Asdf@123'),
            'fullName' => Str::random(10),
            'state' => 'Brisbane',
            'suburb' => 'Mt Gravatt',
            'role' => 9,
            'status' => 1
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;
class InventoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('inventory_tbl')->insert([
            // 'name' => Str::random(10),
            // 'email' => Str::random(10).'@gmail.com',
            // 'password' => Hash::make('password'),

            'prodId' => Str::random(10),
            'prodName' => Str::random(10),
            'category' => Str::random(10),
            'qty' => rand(0, 12),
            'basePrice' => rand(0, 12),
            'sellingPrice' => rand(0, 12),
            'reorderPoint' => rand(0, 12),
            'status' => false
        ]);

        // php artisan db:seed --class=InventoryTableSeeder
    }
}

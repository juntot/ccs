<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoryTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inventory_tbl', function (Blueprint $table) {
            $table->string('prodId')->primary();
            $table->string('prodName');
            $table->string('category');
            $table->string('qty');
            $table->string('basePrice');
            $table->string('sellingPrice');
            $table->string('reorderPoint');
            $table->string('addedby_')->nullable();
            $table->string('updatedby_')->nullable();
            $table->timestamps();
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('inventory_tbl');
    }

    // php artisan migrate --path=/database/migrations/saas/
    // php artisan migrate:fresh --path=/database/migrations/saas
}

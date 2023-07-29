<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inventory_category_tbl', function (Blueprint $table) {
            $table->string('categoryId')->primary();
            $table->string('categoryName');
            $table->string('addedby_')->nullable();
            $table->string('updatedby_')->nullable();
            $table->timestamps();
            // $table->boolean('status');
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
        Schema::drop('inventory_category_tbl');
    }
}

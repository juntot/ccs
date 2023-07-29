<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SupplierTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('supplier_tbl', function (Blueprint $table) {
            $table->string('supId')->primary();
            $table->string('supName');
            $table->string('supAddress');
            $table->string('supNumber');
            $table->string('supBankName');
            $table->string('supBankAccnt');
            $table->string('supBankBsb');
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
        Schema::drop('supplier_tbl');
    }
}

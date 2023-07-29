<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tbl', function (Blueprint $table) {
            // $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fullName');
            // $table->string('lastName');
            // $table->string('middleName');
            $table->string('state');
            $table->string('suburb');
            $table->string('role');
            $table->string('status');
            // $table->timestamp('email_verified_at')->nullable();
            // $table->rememberToken();
            $table->string('updatedby_')->nullable();
            $table->timestamps();
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
        Schema::drop('user_tbl');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tbl', function (Blueprint $table) {
            $table->string('userId')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('fullname')->nullable();
            $table->string('section')->nullable();
            $table->string('guardian')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->tinyInteger('role')->default('0');
            $table->dateTime('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            // $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

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
            $table->string('userId')->primary();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->longText('qrcode')->nullable();
            $table->string('fullname')->nullable();
            $table->string('section')->nullable();
            $table->string('guardian')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->tinyInteger('role')->default('0');
            $table->dateTime('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('status')->default('1');
            // $table->rememberToken();
            // $table->timestamps();
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

// php artisan migrate --path=/database/migrations/saas/
// php artisan migrate:fresh --path=/database/migrations/saas

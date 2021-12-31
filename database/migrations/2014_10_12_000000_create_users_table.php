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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('Uid');
            $table->string('First Name');
            $table->string('Last Name');
            $table->string('Email')->unique();
            $table->char('PhoneNo',10);
            $table->string('Address');
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('Password');
            $table->timestamp('LastSeen')->nullable();
            $table->rememberToken();
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

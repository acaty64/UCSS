<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username', 6)->unique;
            $table->string('password');
            $table->string('wdoc1', 30);
            $table->string('wdoc2', 30);
            $table->string('wdoc3', 30);
            $table->enum('type',['01','02','03','09'])->default('02')->onDelete('cascade');
            $table->boolean('swcierre');
            $table->rememberToken();
            $table->timestamps();
            $table->string('slug');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

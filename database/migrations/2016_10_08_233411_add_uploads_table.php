<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denvios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename',60);
            $table->string('fileuser',60);
            $table->string('tipo',2);
            $table->string('subtipo',2);
            $table->integer('user_id')->unsigned;

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
    }
}

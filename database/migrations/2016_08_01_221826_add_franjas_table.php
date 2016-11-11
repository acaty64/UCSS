<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFranjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franjas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dia');
            $table->integer('turno');
            $table->integer('hora');
            $table->string('wfranja',11);
            //$table->string('semestre',6);
            $table->string('csede',3);

            //$table->integer('semestr_id')->unsigned();
            $table->integer('sede_id')->unsigned();

            //$table->foreign('semestr_id')->references('id')->on('semestres')->onDelete('cascade');
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
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
        Schema::drop('franjas');
    }
}

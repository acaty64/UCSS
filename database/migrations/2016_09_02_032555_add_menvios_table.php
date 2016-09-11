<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMenviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menvios', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fenvio');
            $table->date('flimite');
            $table->string('tx_need');
            $table->integer('envios');
            $table->integer('rptas');
            $table->string('tipo', 4);
            $table->string('tablename', 20);

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

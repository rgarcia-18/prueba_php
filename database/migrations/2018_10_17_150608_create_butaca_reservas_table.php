<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButacaReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('butaca_reservas', function (Blueprint $table) {       
            $table->integer('fila');
            $table->integer('columna');
            $table->integer('ind_estado');
            $table->integer('id_reserva')->unsigned();
            $table->foreign('id_reserva')->references('id')->on('reservas');
            $table->timestamps();
            $table->primary(['fila','columna','ind_estado']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('butaca_reservas');
    }
}

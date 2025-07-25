<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantesTable extends Migration
{
    public function up()
    {
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->increments('id_restaurante'); 
            $table->string('nombre_restaurante', 100);
            $table->string('direccion_restaurante', 100);
            $table->string('telefono_restaurante', 20);
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurantes');
    }
}

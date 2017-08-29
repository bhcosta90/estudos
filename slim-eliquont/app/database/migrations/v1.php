<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
* Example migration for use with "novice"
*/
class v1 {
    function run()
    {
        Capsule::schema()->dropIfExists('automovel_dados');
        Capsule::schema()->dropIfExists('automovel');
        Capsule::schema()->dropIfExists('usuario');

        Capsule::schema()->create('usuario', function($table) {
            $table->increments('id');
            $table->string('login');
            $table->string('senha');
            $table->timestamps();
            $table->timestamp('remove_at')->nullable();
        });

        Capsule::schema()->create('automovel', function($table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('uf', 3);
            $table->string('cidade');
            $table->text('descricao');
            $table->integer('id_usuario')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('remove_at')->nullable();
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('restrict')->onUpdate('cascade');
        });

        Capsule::schema()->create('automovel_dados', function($table) {
            $table->integer('id_automovel')->unsigned();
            $table->string('chave');
            $table->text('valor');
            $table->primary(array('id_automovel', 'chave'));
            $table->foreign('id_automovel')->references('id')->on('automovel')->onDelete('cascade')->onUpdate('cascade');;
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthrolmodulopermisos extends Migration
{

    public function up()
    {
        Schema::create('authrolmodulopermisos', function (Blueprint $table) {
            $table->increments('rolmodulopermisoid');
            $table->integer('rolid')->unsigned();
            $table->integer('modulopermisoid')->unsigned();
            $table->timestamps();

            $table->foreign('rolid')->references('rolid')->on('authroles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('modulopermisoid')->references('modulopermisoid')->on('authmodulopermisos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('authrolmodulopermisos');
    }

}

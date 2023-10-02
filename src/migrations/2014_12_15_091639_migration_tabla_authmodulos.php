<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthmodulos extends Migration
{

    public function up()
    {
        Schema::create('authmodulos', function (Blueprint $table) {
            $table->increments('moduloid');
            $table->string('nombre', 50);
            $table->string('nombrefriendly', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('authmodulos');
    }

}

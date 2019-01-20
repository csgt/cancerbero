<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('roles');
    }
}

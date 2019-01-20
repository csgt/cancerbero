<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id');
            $table->string('name', 50);
            $table->string('description', 50);

            $table->foreign('parent_id')->references('id')->on('permissions')->onUpate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('permissions');
    }
}

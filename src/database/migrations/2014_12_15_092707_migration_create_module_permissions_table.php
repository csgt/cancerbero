<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCreateModulePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('module_permissions');
    }
}

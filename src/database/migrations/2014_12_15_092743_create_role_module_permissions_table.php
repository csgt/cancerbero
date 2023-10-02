<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleModulePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('role_module_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('module_permission_id');
            $table->timestamps();

            $table->unique(['role_id', 'module_permission_id']);

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('module_permission_id')->references('id')->on('module_permissions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('role_module_permissions');
    }
}

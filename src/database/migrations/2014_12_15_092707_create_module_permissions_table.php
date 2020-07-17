<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('module_id');
            $table->unsignedBiginteger('permission_id');

            $table->unique(['module_id', 'permission_id']);
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('module_permissions');
    }
}

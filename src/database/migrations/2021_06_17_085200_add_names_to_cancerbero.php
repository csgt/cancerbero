<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNamesToCancerbero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('menus', 'module_permission_id')) {
            DB::unprepared("TRUNCATE TABLE menus");
            Schema::table('menus', function (Blueprint $table) {
                $table->string('parent_route')->after('order')->nullable()->default(null);
                $table->dropForeign(['module_permission_id']);
                $table->dropForeign(['parent_id']);
                $table->dropColumn('module_permission_id');
                $table->dropColumn('parent_id');
                $table->boolean('has_children')->default(false)->after('icon');
            });
        }

        DB::unprepared("TRUNCATE TABLE role_module_permissions");
        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->string('module_permission')->after('role_id');
            $table->dropForeign(['module_permission_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn('module_permission_id');
            $table->dropUnique(['role_id', 'module_permission_id']);
        });

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        DB::unprepared("TRUNCATE TABLE module_permissions");
        Schema::table('module_permissions', function (Blueprint $table) {
            $table->string('name');

            $table->dropForeign(['module_id']);
            $table->dropForeign(['permission_id']);

            $table->dropColumn('id');
            $table->dropUnique(['module_id', 'permission_id']);
            $table->dropColumn('module_id');
            $table->dropColumn('permission_id');
        });
        DB::unprepared("ALTER TABLE `module_permissions` ADD PRIMARY KEY (`name`)");

        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        DB::unprepared("ALTER TABLE `modules` ADD PRIMARY KEY (`name`)");

        DB::unprepared("TRUNCATE TABLE permissions");
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('parent')->after('name')->nullable()->default(null);
            $table->dropForeign(['parent_id']);
            $table->dropColumn('id');
            $table->dropColumn('parent_id');
        });
        DB::unprepared("ALTER TABLE `permissions` ADD PRIMARY KEY (`name`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("TRUNCATE TABLE permissions");
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropPrimary('name');
            $table->dropColumn('parent');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->unsignedInteger('parent_id')->after('id')->nullable()->default(null);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('permissions');
        });

        DB::unprepared("TRUNCATE TABLE modules");
        Schema::table('modules', function (Blueprint $table) {
            $table->string('temp');
            $table->dropPrimary('name');
            $table->dropColumn('name');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->dropColumn('temp');
        });

        DB::unprepared("TRUNCATE TABLE module_permissions");
        Schema::table('module_permissions', function (Blueprint $table) {
            $table->string('temp');
            $table->dropColumn('name');
        });

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->unsignedInteger('module_id')->after('id');
            $table->unsignedInteger('permission_id')->after('module_id');
        });

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->unique(['module_id', 'permission_id']);
        });

        DB::unprepared("TRUNCATE TABLE role_module_permissions");
        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->unsignedInteger('module_permission_id')->after('id');
            $table->dropColumn('module_permission');
            $table->foreign('module_permission_id')->references('id')->on('module_permissions');
            $table->unique(['role_id', 'module_permission_id']);
        });

        if (Schema::hasColumn('menus', 'module_permission')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->unsignedInteger('parent_id');
                $table->dropColumn('has_children');
                $table->dropColumn('module_permission');
                $table->foreign('module_permission_id')->references('id')->on('module_permissions');
            });
        }
    }
}

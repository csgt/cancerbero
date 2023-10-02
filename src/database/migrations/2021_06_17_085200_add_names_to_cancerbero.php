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
        Schema::disableForeignKeyConstraints();

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('parent')->after('name')->nullable()->default(null);
        });

        DB::unprepared("UPDATE permissions t1 INNER JOIN permissions t2 ON t2.id = t1.parent_id SET t1.parent = t2.name");

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->string('name');
        });
        DB::unprepared("UPDATE module_permissions mp SET mp.name=CONCAT( (SELECT name FROM modules WHERE id=mp.module_id), '.', (SELECT name FROM permissions WHERE id=mp.permission_id))");

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->string('module_permission')->after('role_id');
        });

        DB::unprepared("UPDATE role_module_permissions rmp SET rmp.module_permission = (SELECT name FROM module_permissions WHERE id=rmp.module_permission_id)");

        if (Schema::hasColumn('menus', 'module_permission_id')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->string('parent_route')->after('order')->nullable()->default(null);
                $table->boolean('has_children')->default(false)->after('icon');
            });
        }

        //Update parent_route with current data
        DB::unprepared("UPDATE menus t1 INNER JOIN menus t2 ON t2.id = t1.parent_id SET t1.parent_route = t2.route");
        DB::unprepared("UPDATE menus SET has_children=(parent_id IS NOT NULL)");

        //Drop all unused columns
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['module_permission_id']);
            $table->dropForeign(['parent_id']);
            $table->dropColumn('module_permission_id');
            $table->dropColumn('parent_id');
        });

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->dropForeign(['module_permission_id']);
            $table->dropForeign(['role_id']);
            $table->dropUnique(['role_id', 'module_permission_id']);
            $table->dropColumn('module_permission_id');
        });

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('module_permissions', function (Blueprint $table) {
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

        //Drop all unused columns
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('id');
            $table->dropColumn('parent_id');
        });
        DB::unprepared("ALTER TABLE `permissions` ADD PRIMARY KEY (`name`)");

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dd('no down');
    }
}

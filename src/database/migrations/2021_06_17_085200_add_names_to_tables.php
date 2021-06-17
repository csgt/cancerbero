<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNamesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->string('name');

            $table->dropForeign(['module_id']);
            $table->dropForeign(['permission_id']);
        });
        DB::unprepared("UPDATE module_permissions AS mp SET name = (SELECT CONCAT(name, '.', (SELECT name FROM permissions WHERE id = mp.permission_id)) FROM modules WHERE id = mp.module_id)");

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->string('module_permission')->after('role_id');
            $table->dropForeign(['module_permission_id']);
        });
        DB::unprepared("UPDATE role_module_permissions AS rmp SET module_permission = (SELECT name FROM module_permissions WHERE id = rmp.module_permission_id)");

        // Schema::table('menus', function (Blueprint $table) {
        //     $table->string('module_permission')->after('parent_id')->nullable()->default(null);
        //     $table->dropForeign(['module_permission_id']);
        // });
        // DB::unprepared("UPDATE menus AS m SET module_permission = (SELECT name FROM module_permissions WHERE id = m.module_permission_id)");

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('parent')->after('name')->nullable()->default(null);
            $table->dropForeign(['parent_id']);
        });
        DB::unprepared("UPDATE permissions p2, (SELECT id, name FROM permissions) p1 SET p2.parent = p1.name WHERE p1.id = p2.parent_id;");

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('parent');
            $table->foreign('parent_id')->references('id')->on('permissions');
        });

        // Schema::table('menus', function (Blueprint $table) {
        //     $table->dropColumn('module_permission');
        //     $table->foreign('module_permission_id')->references('id')->on('module_permissions');
        // });

        Schema::table('role_module_permissions', function (Blueprint $table) {
            $table->dropColumn('module_permission');
            $table->foreign('module_permission_id')->references('id')->on('module_permissions');
        });

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        Schema::enableForeignKeyConstraints();
    }
}

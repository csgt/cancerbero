<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKeysOnTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_permissions', function (Blueprint $table) {
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

        Schema::table('permissions', function (Blueprint $table) {
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
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropPrimary('name');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->unsignedInteger('parent_id')->after('id')->nullable()->default(null);
        });
        DB::unprepared("UPDATE permissions p2, (SELECT id, NAME FROM permissions) p1 SET p2.parent_id = p1.id WHERE p1.name = p2.parent;");

        Schema::table('modules', function (Blueprint $table) {
            $table->dropPrimary('name');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->increments('id')->first();
        });

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->dropPrimary('name');
        });

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->unsignedBigInteger('module_id')->after('id');
            $table->unsignedBigInteger('permission_id')->after('module_id');
        });

        $mps = DB::table('module_permissions')->get();
        foreach ($mps as $mp) {
            $mparr      = explode('.', $mp->name);
            $permission = end($mparr);

            array_pop($mparr);

            $module = implode('.', $mparr);

            $module_obj     = DB::table('modules')->where('name', $module)->first();
            $permission_obj = DB::table('permissions')->where('name', $permission)->first();

            DB::table('module_permissions')->where('id', $mp->id)->update([
                'module_id'     => $module_obj->id,
                'permission_id' => $permission_obj->id,
            ]);
        }

        Schema::table('module_permissions', function (Blueprint $table) {
            $table->unique(['module_id', 'permission_id']);
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationAlterUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyinteger('active')->default(1)->after('password');
            $table->binary('avatar')->nullable()->after('active');
            $table->datetime('password_change')->nullable()->after('avatar');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('avatar');
            $table->dropColumn('password_change');
        });
    }
}

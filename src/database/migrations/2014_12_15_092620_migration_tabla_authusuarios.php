<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthusuarios extends Migration {

	public function up() {
		Schema::create('authusuarios', function(Blueprint $table) {
			$table->increments('usuarioid');
			$table->string('email',255);
			$table->string('password',255);
			$table->integer('rolid')->unsigned();
			$table->string('nombre',255);
			$table->tinyinteger('activo')->default(1);
			$table->rememberToken();
			$table->string('twostepsecret',255)->nullable()->default(null);
			$table->string('facebookid',255)->nullable()->default(null);
			$table->string('googleid',255)->nullable()->default(null);
			$table->datetime('cambiarpassword')->nullable()->default(null);
			$table->nullableTimestamps();
			$table->foreign('rolid')->references('rolid')->on('authroles')->onDelete('restrict')->onUpdate('cascade');
		
			$table->unique('email');
		});
	}

	public function down() {
		Schema::drop('authusuarios');
	}
}
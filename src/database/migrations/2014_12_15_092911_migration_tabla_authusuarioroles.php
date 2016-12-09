<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthusuarioroles extends Migration {

	public function up() {
		Schema::create('authusuarioroles', function(Blueprint $table) {
			$table->increments('usuariorolid');
			$table->integer('usuarioid')->unsigned();
			$table->integer('rolid')->unsigned();
			$table->timestamps();

			$table->unique(['usuarioid','rolid']);
			$table->foreign('usuarioid')->references('usuarioid')->on('authusuarios')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('rolid')->references('rolid')->on('authroles')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down() {
		Schema::drop('authusuarioroles');
	}

}

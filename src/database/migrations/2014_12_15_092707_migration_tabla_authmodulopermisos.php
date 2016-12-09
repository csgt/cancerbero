<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthmodulopermisos extends Migration {

	public function up() {
		Schema::create('authmodulopermisos', function(Blueprint $table) {
			$table->increments('modulopermisoid');
			$table->integer('moduloid')->unsigned();
			$table->integer('permisoid')->unsigned();
			$table->timestamps();

			$table->foreign('moduloid')->references('moduloid')->on('authmodulos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('permisoid')->references('permisoid')->on('authpermisos')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	public function down() {
		Schema::drop('authmodulopermisos');
	}

}

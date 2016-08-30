<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaHistoricopasswords extends Migration {

	public function up() {
		Schema::create('authhistoricopasswords', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('usuarioid')->unsigned();
			$table->string('password');
			$table->nullableTimestamps();

			$table->foreign('usuarioid')->references('usuarioid')->on('authusuarios');
		});
	}

	public function down() {
		Schema::drop('authhistoricopasswords');
	}
}
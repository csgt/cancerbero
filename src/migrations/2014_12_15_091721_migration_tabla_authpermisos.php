<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthpermisos extends Migration {

	public function up() {
		Schema::create('authpermisos', function(Blueprint $table) {
			$table->increments('permisoid');
			$table->string('nombre',50);
			$table->string('nombrefriendly',50);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::drop('authpermisos');
	}

}

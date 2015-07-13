<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationTablaAuthroles extends Migration {

	public function up() {
		Schema::create('authroles', function(Blueprint $table) {
			$table->increments('rolid');
			$table->string('nombre',50);
			$table->string('descripcion',255);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::drop('authroles');
	}

}

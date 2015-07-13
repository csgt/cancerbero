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
			$table->tinyinteger('cambiopassword')->default(1);
			$table->tinyinteger('notificar')->default(0);
			$table->rememberToken();
			$table->string('twostepsecret',255);
			$table->string('facebookid',255);
			$table->string('googleid',255);
			$table->timestamps();
			$table->foreign('rolid')->references('rolid')->on('authroles')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down() {
		Schema::drop('authusuarios');
	}

}

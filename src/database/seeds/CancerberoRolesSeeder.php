<?php
	class CancerberoRolesSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authroles')->truncate();

			DB::table('authroles')->insert(array(
				'rolid'       => 1,
				'nombre'      => 'CS Admin',
				'descripcion' => 'Rol backdoor',
				'created_at'  => date_create(), 'updated_at' => date_create()
			));
				  
		  DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
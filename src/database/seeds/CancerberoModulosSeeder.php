<?php
	class CancerberoModulosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authmodulos')->truncate();

			DB::table('authmodulos')->insert(array(
				'moduloid'       => 1,
				'nombre'         => 'index',
				'nombrefriendly' => 'Inicio',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulos')->insert(array(
				'moduloid'       => 2,
				'nombre'         => 'usuarios',
				'nombrefriendly' => 'Administración de usuarios',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulos')->insert(array(
				'moduloid'       => 3,
				'nombre'         => 'roles',
				'nombrefriendly' => 'Administración de roles',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
				  
		  DB::statement('SET FOREIGN_KEY_CHECKS=1')
		}
	}
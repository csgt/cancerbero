<?php
	class CancerberoPermisosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authpermisos')->truncate();

			DB::table('authpermisos')->insert(array(
				'permisoid'       => 1,
				'nombre'         => 'index',
				'nombrefriendly' => 'Ver'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 2,
				'nombre'         => 'create',
				'nombrefriendly' => 'Crear'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 3,
				'nombre'         => 'store',
				'nombrefriendly' => 'Guardar'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 4,
				'nombre'         => 'edit',
				'nombrefriendly' => 'Editar'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 5,
				'nombre'         => 'update',
				'nombrefriendly' => 'Actualizar'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 6,
				'nombre'         => 'destroy',
				'nombrefriendly' => 'Borrar'
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 7,
				'nombre'         => 'show',
				'nombrefriendly' => 'Mostrar datos'
			));
		  
		  DB::table('authpermisos')->update(array('created_at'=>date_create(), 'updated_at'=>date_create()));	  
		  DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
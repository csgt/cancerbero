<?php
	class CancerberoPermisosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authpermisos')->truncate();

			DB::table('authpermisos')->insert(array(
				'permisoid'       => 1,
				'nombre'         => 'index',
				'nombrefriendly' => 'Ver',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 2,
				'nombre'         => 'create',
				'nombrefriendly' => 'Crear',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 3,
				'nombre'         => 'store',
				'nombrefriendly' => 'Guardar',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 4,
				'nombre'         => 'edit',
				'nombrefriendly' => 'Editar',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 5,
				'nombre'         => 'update',
				'nombrefriendly' => 'Actualizar',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 6,
				'nombre'         => 'destroy',
				'nombrefriendly' => 'Borrar',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authpermisos')->insert(array(
				'permisoid'       => 7,
				'nombre'         => 'show',
				'nombrefriendly' => 'Mostrar datos',
				'created_at'     => date_create(), 'updated_at' => date_create()
			));
		  
		  DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
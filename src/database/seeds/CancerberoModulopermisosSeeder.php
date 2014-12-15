<?php
	class CancerberoModuloPermisosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authmodulopermisos')->truncate();

			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 1,
				'moduloid'        => 1,
				'permisoid' 			=> 1,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 2,
				'moduloid'        => 2,
				'permisoid' 			=> 1,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 3,
				'moduloid'        => 2,
				'permisoid' 			=> 2,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 4,
				'moduloid'        => 2,
				'permisoid' 			=> 3,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 5,
				'moduloid'        => 2,
				'permisoid' 			=> 4,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 6,
				'moduloid'        => 2,
				'permisoid' 			=> 5,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 7,
				'moduloid'        => 2,
				'permisoid' 			=> 6,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 8,
				'moduloid'        => 2,
				'permisoid' 			=> 7,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 9,
				'moduloid'        => 3,
				'permisoid' 			=> 1,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 10,
				'moduloid'        => 3,
				'permisoid' 			=> 2,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 11,
				'moduloid'        => 3,
				'permisoid' 			=> 3,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 12,
				'moduloid'        => 3,
				'permisoid' 			=> 4,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 13,
				'moduloid'        => 3,
				'permisoid' 			=> 5,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 14,
				'moduloid'        => 3,
				'permisoid' 			=> 6,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
		
			DB::table('authmodulopermisos')->insert(array(
				'modulopermisoid'	=> 15,
				'moduloid'        => 3,
				'permisoid' 			=> 7,
				'created_at'     	=> date_create(), 'updated_at' => date_create()
			));
			
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
<?php
	class CancerberoRolModuloPermisosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authrolmodulopermisos')->truncate();

			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 1,
				'rolid'              => 1,
				'modulopermisoid'    => 1
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 2,
				'rolid'              => 1,
				'modulopermisoid'    => 2
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 3,
				'rolid'              => 1,
				'modulopermisoid'    => 3
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 4,
				'rolid'              => 1,
				'modulopermisoid'    => 4
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 5,
				'rolid'              => 1,
				'modulopermisoid'    => 5
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 6,
				'rolid'              => 1,
				'modulopermisoid'    => 6
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 7,
				'rolid'              => 1,
				'modulopermisoid'    => 7
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 8,
				'rolid'              => 1,
				'modulopermisoid'    => 8
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 9,
				'rolid'              => 1,
				'modulopermisoid'    => 9
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 10,
				'rolid'              => 1,
				'modulopermisoid'    => 10
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 11,
				'rolid'              => 1,
				'modulopermisoid'    => 11
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 12,
				'rolid'              => 1,
				'modulopermisoid'    => 12
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 13,
				'rolid'              => 1,
				'modulopermisoid'    => 13
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 14,
				'rolid'              => 1,
				'modulopermisoid'    => 14
			));
			DB::table('authrolmodulopermisos')->insert(array(
				'rolmodulopermisoid' => 15,
				'rolid'              => 1,
				'modulopermisoid'    => 15
			));

			DB::table('authrolmodulopermisos')->update(array('created_at'=>date_create(), 'updated_at'=>date_create()));

			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
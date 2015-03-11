<?php
	class CancerberoUsuariosSeeder extends Seeder {
		public function run(){
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('authusuarios')->truncate();

			DB::table('authusuarios')->insert(array(
				'usuarioid'  => 1,
				'email'      => 'cs@cs.com.gt',
				'password'   => '$2y$10$zOrPimtXtgVXl/nphcryoeo/mxS0oB6uBQZpmZFIB8M8ad1wc9vMi',
				'nombre'     => 'Compuservice',
				'rolid'      => 1
			));
				  
			DB::table('authusuarios')->update(array('created_at'=>date_create(), 'updated_at'=>date_create()));	
		  DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
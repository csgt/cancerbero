<?php
class CancerberoModuloPermisosSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('authmodulopermisos')->truncate();

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 1,
            'moduloid'        => 1,
            'permisoid'       => 1,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 2,
            'moduloid'        => 2,
            'permisoid'       => 1,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 3,
            'moduloid'        => 2,
            'permisoid'       => 2,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 4,
            'moduloid'        => 2,
            'permisoid'       => 3,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 5,
            'moduloid'        => 2,
            'permisoid'       => 4,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 6,
            'moduloid'        => 2,
            'permisoid'       => 5,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 7,
            'moduloid'        => 2,
            'permisoid'       => 6,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 8,
            'moduloid'        => 2,
            'permisoid'       => 7,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 9,
            'moduloid'        => 3,
            'permisoid'       => 1,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 10,
            'moduloid'        => 3,
            'permisoid'       => 2,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 11,
            'moduloid'        => 3,
            'permisoid'       => 3,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 12,
            'moduloid'        => 3,
            'permisoid'       => 4,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 13,
            'moduloid'        => 3,
            'permisoid'       => 5,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 14,
            'moduloid'        => 3,
            'permisoid'       => 6,
        ]);

        DB::table('authmodulopermisos')->insert([
            'modulopermisoid' => 15,
            'moduloid'        => 3,
            'permisoid'       => 7,
        ]);

        DB::table('authmodulopermisos')->update(['created_at' => date_create(), 'updated_at' => date_create()]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}

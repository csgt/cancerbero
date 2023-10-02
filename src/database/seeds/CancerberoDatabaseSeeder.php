<?php

class CancerberoDatabaseSeeder extends Seeder
{

    public function run()
    {
        Eloquent::unguard();
        $this->call('CancerberoModulosSeeder');
        $this->call('CancerberoPermisosSeeder');
        $this->call('CancerberoModuloPermisosSeeder');
        $this->call('CancerberoRolesSeeder');
        $this->call('CancerberoUsuariosSeeder');
        $this->call('CancerberoRolModuloPermisosSeeder');
    }

}

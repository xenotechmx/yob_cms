<?php

use Illuminate\Database\Seeder;

use MetodikaTI\Permission as P;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $read = array('name'=>"READ", 'bit'=>1);
        P::create($read);
        $create = array('name'=>"CREATE", 'bit'=>2);
        P::create($create);
        $update = array('name'=>"UPDATE", 'bit'=>3);
        P::create($update);
        $delete = array('name'=>"DELETE", 'bit'=>4);
        P::create($delete);
    }
}

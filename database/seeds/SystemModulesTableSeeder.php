<?php

use Illuminate\Database\Seeder;

use MetodikaTI\SystemModule as SM;

class SystemModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = array(
            'name'=>'Dashboard',
            'url' => '/',
            'icon' => 'ti-blackboard',
            'parent' => 0,
            'order' => 1,
            'parent_as_child' => 1
        );
        SM::create($system);
        $users = array(
            'name'=>'Sistema',
            'url' => 'system',
            'icon' => 'ti-settings',
            'parent' => 0,
            'order' => 2,
            'parent_as_child' => 0
        );
        SM::create($users);
        $profiles = array(
            'name'=>'Usuarios',
            'url' => 'system/user',
            'icon' => 'ti-angle-right',
            'parent' => 2,
            'order' => 1,
            'parent_as_child' => 0
        );
        SM::create($profiles);
        $profiles = array(
            'name'=>'Perfiles',
            'url' => 'system/profile',
            'icon' => 'ti-angle-right',
            'parent' => 2,
            'order' => 2,
            'parent_as_child' => 0
        );
        SM::create($profiles);
    }
}

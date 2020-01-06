<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $seeders = array(
            UsersTableSeeder::class,
            UserProfilesTableSeeder::class,
            SystemModulesTableSeeder::class,
            PermissionsTableSeeder::class,
        );
        $this->call($seeders);
    }
}

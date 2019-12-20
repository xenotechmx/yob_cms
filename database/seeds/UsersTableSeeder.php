<?php

use Illuminate\Database\Seeder;

use MetodikaTI\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demon = array(
            'name' => 'Demon',
            'email' => 'demon@metodika.mx',
            'password' => bcrypt('Huo0lpaw@'),
            'user_profile_id' => 1,
        );
        User::create($demon);

        $guest = array(
            'name' => 'Invitado',
            'email' => 'invitado@metodika.mx',
            'password' => bcrypt('Huo0lpaw@'),
            'user_profile_id' => 2,
        );
        User::create($guest);
    }
}

<?php

use Illuminate\Database\Seeder;

use MetodikaTI\UserProfile;

class UserProfilesTableSeeder extends Seeder
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
            'permits' => '{"1":[1,1,1,1],"2":[1,1,1,1],"3":[1,1,1,1],"4":[1,1,1,1]}',
        );

        UserProfile::create($demon);
        $demon['name'] = "Invitado";
        UserProfile::create($demon);
    }
}

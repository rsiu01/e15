<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # required for p3
        $user = User::updateOrCreate(
            ['email' => 'jill@harvard.edu', 'first_name' => 'Jill', 'last_name' => 'Harvard'],
            ['password' => Hash::make('helloworld'), 'api_token' => Str::random(60)
            ]
        );
        
        $user = User::updateOrCreate(
            ['email' => 'jamal@harvard.edu', 'first_name' => 'Jamal', 'last_name' => 'Harvard'],
            ['password' => Hash::make('helloworld'),'api_token' => Str::random(60)
        ]
        );

        $user = User::updateOrCreate(
            ['email' => 'rsiu01@gmail.com', 'first_name' => 'Richard', 'last_name' => 'Siu'],
            ['password' => Hash::make('helloworld'), 'api_token' => Str::random(60)
        ]
        );
    }
}

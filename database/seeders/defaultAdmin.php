<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
    */

    public function run()
    {
        User::create(
            [
                'first_name' => 'Default',
                'last_name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );
        User::create(
            [
                'first_name' => 'Default',
                'last_name' => 'User',
                'username' => 'user',
                'email' => 'moderator@email.com',
                'password' => bcrypt('password'),
                'role' => 'moderator'  
            ]
        );
    }
}

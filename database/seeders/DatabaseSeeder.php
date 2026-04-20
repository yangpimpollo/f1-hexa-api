<?php

namespace Database\Seeders;

use yangpimpollo\L3_infrastructure\Model\my_user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        my_user::create([
            'username' => 'string',
            'email' => 'admin@example.com',
            'password' => Hash::make('string'),
        ]);
    }
}

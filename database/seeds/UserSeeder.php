<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->delete();
        User::create([
            'name' => 'Ezequiel',
            'email' => 'ezequiel@test.com',
            'password' => Hash::make('secret'),
            'role' => 'administrator'
        ]);
        User::create([
            'name' => 'webtools',
            'email' => 'webtools@test.com',
            'password' => Hash::make('secret'),
            'role' => 'administrator'
        ]);


        /**
         * Let's create 10 employees
         */
        factory(User::class, 10)->create();
    }
}

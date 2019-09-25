<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use \App\Models\Company;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Company::query()->delete();
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
        factory(User::class, 50)->create();
    }
}

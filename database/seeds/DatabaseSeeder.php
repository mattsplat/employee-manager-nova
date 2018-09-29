<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeSeeder::class);
        \App\User::create([
            'email' => 'admin@www.com',
            'name' => 'Addy Jones',
            'password' => '123'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
                'username' => '000000',
                'password' => bcrypt('000000'),
                'wdoc1' => 'Master',
                'wdoc2' => 'AP1',
                'wdoc3' => 'AM1',
                'type' => '09'
        ]);
    }
}

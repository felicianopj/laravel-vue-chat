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
        DB::table('users')->delete();
        
        App\User::create([
        	'name' => 'Joseph',
        	'email' => 'joseph@mail.com',
        	'password' => bcrypt(123)
        ]);

        App\User::create([
        	'name' => 'Jotaro',
        	'email' => 'jotaro@mail.com',
        	'password' => bcrypt(123)
        ]);
    }
}

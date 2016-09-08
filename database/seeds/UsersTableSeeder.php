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
        	'name' => 'User1',
        	'email' => 'user1@mail.com',
        	'password' => bcrypt(123)
        ]);

        App\User::create([
            'name' => 'User2',
            'email' => 'user2@mail.com',
            'password' => bcrypt(123)
        ]);

        App\User::create([
        	'name' => 'User3',
        	'email' => 'user3@mail.com',
        	'password' => bcrypt(123)
        ]);
    }
}

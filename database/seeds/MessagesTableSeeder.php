<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->delete();

        App\Message::create([
        	'sender_id' => 1,
        	'receiver_id' => 2,
        	'content' => 'User1 to User2'
        ]);

        App\Message::create([
            'sender_id' => 2,
            'receiver_id' => 1,
            'content' => 'User2 to User1'
        ]);

        App\Message::create([
            'sender_id' => 1,
            'receiver_id' => 2,
            'content' => 'User1 to User2 again'
        ]);

        App\Message::create([
            'sender_id' => 2,
            'receiver_id' => 1,
            'content' => 'User2 to User1 again'
        ]);

        App\Message::create([
        	'sender_id' => 1,
        	'receiver_id' => 3,
        	'content' => 'User1 to User3'
        ]);

        App\Message::create([
        	'sender_id' => 3,
        	'receiver_id' => 1,
        	'content' => 'User3 to User1'
        ]);
    }
}

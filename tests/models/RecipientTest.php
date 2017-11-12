<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipientTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testRecipientCanBeCreated()
    {
        $recipient = \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $this->assertEquals('John Doe', $recipient->name);
        $this->assertEquals('johndoe@example.com', $recipient->email);
    }
}

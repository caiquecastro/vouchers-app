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

    public function testRecipientEmailButBeUnique()
    {
        \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $this->expectExceptionMessage('Duplicate entry \'johndoe@example.com\' for key \'recipients_email_unique\'');

        \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }
}
<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OfferTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testOfferCanBeCreated()
    {
        $recipient = \App\Offer::create([
            'name' => 'Custom Promotion',
            'discount' => 50,
        ]);

        $this->assertEquals('Custom Promotion', $recipient->name);
        $this->assertEquals(50, $recipient->discount);
    }
}

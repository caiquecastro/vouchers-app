<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OfferTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testOfferCanBeCreated()
    {
        $offer = \App\Offer::create([
            'name' => 'Custom Promotion',
            'discount' => 50,
        ]);

        $this->assertEquals('Custom Promotion', $offer->name);
        $this->assertEquals(50, $offer->discount);
    }
}

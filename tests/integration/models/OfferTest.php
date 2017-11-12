<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferTest extends TestCase
{
    use RefreshDatabase;
    
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

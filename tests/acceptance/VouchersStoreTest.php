<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VouchersStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testItGeneratesVouchersForRecipients()
    {
        factory(\App\Recipient::class, 10)->create();

        // When I post to vouchers, it creates a offer voucher for every recipient
        $response = $this->post('/vouchers', [
            'offer_id' => factory(\App\Offer::class)->create()->id,
        ]);

        $response->assertRedirect('/');


        $this->assertEquals(10, \App\Voucher::count());
    }
}

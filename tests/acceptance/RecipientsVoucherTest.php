<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipientsVoucherTest extends TestCase
{
    use RefreshDatabase;

    public function testQueryValidVouchersForEmail()
    {
        $offer = factory('App\Offer')->create();
        $recipient = factory('App\Recipient')->create();

        factory('App\Voucher', 2)->create([
            'recipient_id' => $recipient->id,
        ]);

        factory('App\Voucher', 2)->create();

        $response = $this->get('/api/recipients/'.$recipient->email.'/vouchers');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }
}




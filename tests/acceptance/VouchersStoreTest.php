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
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
        ]);

        $response->assertRedirect('/');


        $this->assertEquals(10, \App\Voucher::count());
    }

    public function testVoucherCanBeRedeemed()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
            'used_at' => null,
        ]);

        $response = $this->post('/vouchers/' . $voucher->id . '/redeem');

        $response->assertStatus(204);

        $this->assertNotNull($voucher->fresh()->used_at);
    }

    public function testExpiredVoucherCannotBeRedeemed()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->subSeconds(10),
            'used_at' => null,
        ]);

        $response = $this->post('/vouchers/' . $voucher->id . '/redeem');

        $response->assertStatus(400);

        $this->assertNull($voucher->fresh()->used_at);
    }
}

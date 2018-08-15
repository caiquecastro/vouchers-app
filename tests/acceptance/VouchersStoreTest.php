<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VouchersStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testItGeneratesVouchersForRecipients()
    {
        $this->withoutExceptionHandling();

        factory(\App\Recipient::class, 10)->create();

        // When I post to vouchers, it creates the offer and
        // a voucher for every recipient on the offer
        $response = $this->post('/vouchers', [
            'offer_name' => 'My Special Offer',
            'offer_discount' => '40',
            'expires_at' => (\Carbon\Carbon::now())->addMonth()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect('/');

        $this->assertEquals(10, \App\Voucher::count());
    }

    public function testItRequiresOfferNameToCreateVouchers()
    {
        factory(\App\Recipient::class, 10)->create();

        $response = $this->post('/vouchers', [
            'offer_discount' => '40',
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
        ]);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors([
            'offer_name' => 'The offer name field is required.',
        ]);

        $this->assertEquals(0, \App\Voucher::count());
    }

    public function testItRequiresOfferDiscountToCreateVouchers()
    {
        factory(\App\Recipient::class, 10)->create();

        $response = $this->post('/vouchers', [
            'offer_name' => 'The Special Offer',
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
        ]);

        $response->assertRedirect('/');

        $response->assertSessionHasErrors([
            'offer_discount' => 'The offer discount field is required.',
        ]);

        $this->assertEquals(0, \App\Voucher::count());
    }

    public function testItParsesExpirationDateOnCustomFormat()
    {
        $this->withoutExceptionHandling();

        factory(\App\Recipient::class, 5)->create();

        $response = $this->post('/vouchers', [
            'offer_name' => 'The Special Offer',
            'offer_discount' => '10',
            'expires_at' => (\Carbon\Carbon::now())->addMonth()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect('/');

        $this->assertEquals(5, \App\Voucher::count());
    }

    public function testVoucherCanBeRedeemed()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
            'used_at' => null,
        ]);

        $response = $this->post('/api/vouchers/' . $voucher->id . '/redeem');

        $response->assertStatus(204);

        $this->assertNotNull($voucher->fresh()->used_at);
    }

    public function testExpiredVoucherCannotBeRedeemed()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->subSeconds(10),
            'used_at' => null,
        ]);

        $response = $this->post('/api/vouchers/' . $voucher->id . '/redeem');

        $response->assertStatus(400);

        $this->assertNull($voucher->fresh()->used_at);
    }
}

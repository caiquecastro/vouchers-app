<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VouchersRedeemTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanRedeemVoucher()
    {
        $recipient = factory('App\Recipient')->create([
            'email' => 'johndoe@example.com',
        ]);

        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->addMonth(),
            'used_at' => null,
            'recipient_id' => $recipient->id,
        ]);

        $response = $this->postJson('/api/vouchers/'.$voucher->code.'/redeem', [
            'email' => 'johndoe@example.com',
        ]);

        $response->assertStatus(204);

        $this->assertNotNull($voucher->fresh()->used_at);
    }

    public function testItCannotRedeemExpiredVoucher()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->subSeconds(10),
            'used_at' => null,
        ]);

        $response = $this->post('/api/vouchers/' . $voucher->code . '/redeem');

        $response->assertStatus(400);

        $this->assertNull($voucher->fresh()->used_at);
    }

    public function testItCannotRedeemVoucherTwice()
    {
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->addMonth(10),
            'used_at' => (\Carbon\Carbon::now())->subSeconds(10),
        ]);

        $response = $this->post('/api/vouchers/' . $voucher->code . '/redeem');

        $response->assertStatus(400);
    }

    public function testItRequiresTheVoucherEmailToRedeem()
    {
        $recipient = factory('App\Recipient')->create([
            'email' => 'johndoe@example.com',
        ]);
        $voucher = factory(\App\Voucher::class)->create([
            'expires_at' => (\Carbon\Carbon::now())->addMonth(10),
            'used_at' => null,
        ]);

        $response = $this->postJson('/api/vouchers/' . $voucher->code . '/redeem', [
            'email' => 'janedoe@example.com',
        ]);

        $response->assertStatus(400);
    }
}

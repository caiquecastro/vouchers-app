<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VoucherTest extends TestCase
{
    use DatabaseTransactions;

    public function testVoucherCanBeCreated()
    {
        $recipient = \App\Recipient::create([]);
        $offer = \App\Offer::create([]);

        $voucher = \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);

        $this->assertNotNull($voucher->code);
    }

    public function testVoucherCodeMustBeUnique()
    {
        $recipient = \App\Recipient::create([]);
        $offer = \App\Offer::create([]);

        \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $this->expectExceptionMessage('Duplicate entry \'\' for key \'vouchers_code_unique\'');

        \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);
    }
}

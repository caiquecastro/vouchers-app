<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoucherTest extends TestCase
{
    use RefreshDatabase;

    public function testVoucherCanBeCreated()
    {
        $recipient = \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
        $offer = \App\Offer::create([
            'name' => 'Greate offer',
            'discount' => 50,
        ]);

        $voucher = \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);

        $this->assertNotNull($voucher->code);
    }

    public function testVoucherCodeMustBeUnique()
    {
        $recipient = \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
        $offer = \App\Offer::create([
            'name' => 'Greate offer',
            'discount' => 50,
        ]);

        \App\Voucher::forceCreate([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
            'code' => 'unique-code',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $this->expectExceptionMessage('Duplicate entry \'unique-code\' for key \'vouchers_code_unique\'');

        \App\Voucher::forceCreate([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
            'code' => 'unique-code',
        ]);
    }

    public function testVoucherGeneratesDifferentCodes()
    {
        $recipient = \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
        $offer = \App\Offer::create([
            'name' => 'Greate offer',
            'discount' => 50,
        ]);

        $firstVoucher = \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);

        $secondVoucher = \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
        ]);

        $this->assertNotEquals($firstVoucher->code, $secondVoucher);
    }

    public function testVoucherCanHaveNullRecipientIfIsNotUsed()
    {
        $offer = \App\Offer::create([
            'name' => 'Greate offer',
            'discount' => 50,
        ]);
        
        $voucher = \App\Voucher::create([
            'offer_id' => $offer->id,
        ]);

        $this->assertNull($voucher->recipient_id);
    }

    public function testVoucherHasAssociationWithRecipientEntity()
    {
        $offer = \App\Offer::create([
            'name' => 'Greate offer',
            'discount' => 50,
        ]);

        $recipient = \App\Recipient::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $voucher = \App\Voucher::create([
            'offer_id' => $offer->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->assertInstanceOf(\App\Recipient::class, $voucher->recipient);
    }
}

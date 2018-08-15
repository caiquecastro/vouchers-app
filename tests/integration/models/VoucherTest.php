<?php

use Carbon\Carbon;
use Tests\TestCase;
use App\Exceptions\AlreadyUsedVoucherException;
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
            'expires_at' => Carbon::now(),
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
            'expires_at' => Carbon::now(),
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $this->expectExceptionMessage('Duplicate entry \'unique-code\' for key \'vouchers_code_unique\'');

        \App\Voucher::forceCreate([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
            'code' => 'unique-code',
            'expires_at' => Carbon::now(),
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
            'expires_at' => Carbon::now(),
        ]);

        $secondVoucher = \App\Voucher::create([
            'recipient_id' => $recipient->id,
            'offer_id' => $offer->id,
            'expires_at' => Carbon::now(),
        ]);

        $this->assertNotEquals($firstVoucher->code, $secondVoucher);
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
            'expires_at' => Carbon::now(),
        ]);

        $this->assertInstanceOf(\App\Recipient::class, $voucher->recipient);
    }

    public function testItThrowsUsedVoucherExceptionWhenUsingItTwice()
    {
        $voucher = factory('App\Voucher')->create([
            'used_at' => Carbon::now(),
        ]);

        $this->expectException(AlreadyUsedVoucherException::class);

        $voucher->use();
    }
}

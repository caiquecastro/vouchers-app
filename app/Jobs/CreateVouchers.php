<?php

namespace App\Jobs;

use App\Offer;
use App\Voucher;
use App\Recipient;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateVouchers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $offer;

    private $expiresAt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Offer $offer, $expiresAt)
    {
        $this->offer = $offer;
        $this->expiresAt = $expiresAt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Recipient::chunk(100, function ($recipients) {
            $recipients->each(function ($recipient) {
                Voucher::create([
                    'offer_id' => $this->offer->id,
                    'recipient_id' => $recipient->id,
                    'expires_at' => $this->expiresAt,
                ]);
            });
        });
    }
}

<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'recipient_id',
        'offer_id',
        'expires_at',
        'used_at',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->code = $model->code ?: Str::random($length = 8);
        });
    }

    public function use()
    {
        return $this->update([
            'used_at' => \Carbon\Carbon::now(),
        ]);
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
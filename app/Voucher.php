<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidVoucherException;
use App\Exceptions\VoucherExpiredException;
use App\Exceptions\AlreadyUsedVoucherException;

class Voucher extends Model
{
    protected $fillable = [
        'recipient_id',
        'offer_id',
        'expires_at',
        'used_at',
    ];

    protected $dates = [
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function use($email)
    {
        if ($this->recipient->email !== $email) {
            throw new InvalidVoucherException('This voucher belongs to another recipient');
        }

        if ($this->expires_at->isPast()) {
            throw new VoucherExpiredException;
        }

        if ($this->used_at !== null) {
            throw new AlreadyUsedVoucherException;
        }

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
<?php

namespace App\Exceptions;

class VoucherExpiredException extends InvalidVoucherException
{
    public function __construct()
    {
        parent::__construct('This voucher is expired');
    }
}
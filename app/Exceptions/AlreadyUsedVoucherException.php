<?php

namespace App\Exceptions;

class AlreadyUsedVoucherException extends InvalidVoucherException
{
    public function __construct()
    {
        parent::__construct('This voucher was already used');
    }
}
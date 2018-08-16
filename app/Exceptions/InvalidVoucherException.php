<?php

namespace App\Exceptions;

class InvalidVoucherException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
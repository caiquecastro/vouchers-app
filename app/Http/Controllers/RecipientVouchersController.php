<?php

namespace App\Http\Controllers;

use App\Recipient;
use Illuminate\Http\Request;

class RecipientVouchersController extends Controller
{
    public function index(Recipient $recipient)
    {
        return $recipient->vouchers;
    }
}

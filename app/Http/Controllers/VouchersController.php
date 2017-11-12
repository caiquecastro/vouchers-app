<?php

namespace App\Http\Controllers;

class VouchersController extends Controller
{
    public function index()
    {
        $vouchers = \App\Voucher::with('offer')->paginate();

        return view('vouchers.index')->withVouchers($vouchers);
    }
}

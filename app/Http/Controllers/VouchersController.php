<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VouchersController extends Controller
{
    public function index()
    {
        $totalVouchers = \App\Voucher::count();
        $usedVouchers = \App\Voucher::where('used_at', '<>', null)->count();
        $unusedVouchers = \App\Voucher::where('used_at', '=', null)->count();

        $vouchers = \App\Voucher::with('offer');

        if (request()->has('q')) {
            $vouchers->where('code', 'LIKE', '%' . request('q') . '%');
        }

        $vouchers = $vouchers->paginate();

        return view('vouchers.index')
            ->with(compact('vouchers', 'totalVouchers', 'usedVouchers', 'unusedVouchers'));
    }

    public function create()
    {
        $offers = \App\Offer::all();

        return view('vouchers.create')->withOffers($offers);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'offer_id' => 'required|exists:offers,id',
            'expires_at' => 'required|date',
        ]);

        $recipients = \App\Recipient::all();

        foreach ($recipients as $recipient) {
            \App\Voucher::create([
                'offer_id' => $request->offer_id,
                'recipient_id' => $recipient->id,
                'expires_at' => $request->expires_at,
            ]);
        }

        return redirect()->route('vouchers.index');
    }

    public function redeem(Voucher $voucher)
    {
        try {
            $voucher->use();
        } catch (\App\Exceptions\VoucherExpiredException $e) {
            return new JsonResponse([], 400);
        }

        return new JsonResponse($voucher, 204);
    }
}

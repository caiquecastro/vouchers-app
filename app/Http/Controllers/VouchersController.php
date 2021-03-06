<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Voucher;
use Carbon\Carbon;
use App\Recipient;
use App\Jobs\CreateVouchers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VouchersController extends Controller
{
    public function index()
    {
        $totalVouchers = Voucher::count();
        $usedVouchers = Voucher::where('used_at', '<>', null)->count();
        $unusedVouchers = Voucher::where('used_at', '=', null)->count();

        $vouchers = Voucher::with('offer');

        // Allow query voucher by its code
        if (request()->has('q')) {
            $vouchers->where('code', request('q'));
        }

        $vouchers = $vouchers->paginate();

        // Create view with the paginated vouchers and the stats
        return view('vouchers.index')
            ->with(compact('vouchers', 'totalVouchers', 'usedVouchers', 'unusedVouchers'));
    }

    public function create()
    {
        $offers = Offer::all();

        return view('vouchers.create')->withOffers($offers);
    }

    public function store(Request $request)
    {
        // Validate the request to create voucher
        $this->validate($request, [
            'offer_name' => 'required',
            'offer_discount' => 'required',
            'expires_at' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Create an offer
        $offer = Offer::create([
            'name' => $request->offer_name,
            'discount' => $request->offer_discount,
        ]);

        CreateVouchers::dispatch($offer, Carbon::parse($request->expires_at));

        return redirect()->route('vouchers.index');
    }

    public function redeem(Voucher $voucher)
    {
        try {
            $voucher->use(request()->input('email'));
        } catch (\App\Exceptions\InvalidVoucherException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 400);
        }

        return new JsonResponse([
            'discount' => $voucher->offer->discount,
        ]);
    }
}

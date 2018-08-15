<?php

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offer = factory('App\Offer')->create();

        factory('App\Voucher', 10)->create([
            'offer_id' => $offer->id,
        ]);
    }
}

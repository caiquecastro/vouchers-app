<?php

use App\Recipient;
use Illuminate\Database\Seeder;

class RecipientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Recipient::class, 100)->create();
    }
}

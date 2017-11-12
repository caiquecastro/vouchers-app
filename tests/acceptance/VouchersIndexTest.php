<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VouchersIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testItHasADashboardForVouchers()
    {
        $this->get('/')
            ->assertResponseOk();
    }
}

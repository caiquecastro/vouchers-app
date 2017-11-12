<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VouchersIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testItHasADashboardForVouchers()
    {
        $this->get('/')
            ->assertResponseOk();
    }
}

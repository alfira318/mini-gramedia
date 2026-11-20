<?php

namespace Tests\Unit;

use App\Service\Midtrans\Midtrans;
use Midtrans\Config;
use Tests\TestCase;

class MidtransConfigurationTest extends TestCase
{
    public function test_it_configures_matching_sandbox_keys(): void
    {
        config([
            'midtrans.server_key' => 'SB-Mid-server-test',
            'midtrans.client_key' => 'SB-Mid-client-test',
            'midtrans.is_production' => false,
            'midtrans.is_sanitized' => true,
            'midtrans.is_3ds' => true,
        ]);

        new Midtrans();

        $this->assertSame('SB-Mid-server-test', Config::$serverKey);
        $this->assertFalse(Config::$isProduction);
    }
}

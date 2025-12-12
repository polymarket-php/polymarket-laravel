<?php

declare(strict_types=1);

namespace Danielgnh\PolymarketLaravel\Tests;

use Danielgnh\PolymarketLaravel\PolymarketServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            PolymarketServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Polymarket' => \Danielgnh\PolymarketLaravel\Facades\Polymarket::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('polymarket.api_key', 'test-api-key');
        $app['config']->set('polymarket.private_key', '0xtest-private-key');
        $app['config']->set('polymarket.chain_id', 137);
        $app['config']->set('polymarket.timeout', 15);
        $app['config']->set('polymarket.retries', 2);
        $app['config']->set('polymarket.verify_ssl', true);
    }
}

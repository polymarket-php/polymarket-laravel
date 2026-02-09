<?php

declare(strict_types=1);

namespace Danielgnh\PolymarketLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use PolymarketPhp\Polymarket\Bridge;
use PolymarketPhp\Polymarket\Client;
use PolymarketPhp\Polymarket\Clob;
use PolymarketPhp\Polymarket\Gamma;

/**
 * @method static Gamma gamma() Get the Gamma API client for market data operations
 * @method static Clob clob() Get the CLOB API client for trading operations
 * @method static Bridge bridge() Get the Bridge API client for cross-chain deposits
 * @method static void auth(?string $privateKey = null, int $nonce = 0) Setup CLOB authentication using private key
 *
 * @see Client
 */
class Polymarket extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}

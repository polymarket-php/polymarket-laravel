<?php

declare(strict_types=1);

use PolymarketPhp\Polymarket\Bridge;
use PolymarketPhp\Polymarket\Client;
use PolymarketPhp\Polymarket\Clob;
use PolymarketPhp\Polymarket\Gamma;
use PolymarketPhp\PolymarketLaravel\Facades\Polymarket;

it('resolves the facade to the client', function () {
    $client = Polymarket::getFacadeRoot();

    expect($client)->toBeInstanceOf(Client::class);
});

it('returns the same instance as the container', function () {
    $facadeClient = Polymarket::getFacadeRoot();
    $containerClient = app(Client::class);

    expect($facadeClient)->toBe($containerClient);
});

it('provides access to gamma api through facade', function () {
    $gamma = Polymarket::gamma();

    expect($gamma)->toBeInstanceOf(Gamma::class);
});

it('provides access to clob api through facade', function () {
    $clob = Polymarket::clob();

    expect($clob)->toBeInstanceOf(Clob::class);
});

it('provides access to bridge api through facade', function () {
    $bridge = Polymarket::bridge();

    expect($bridge)->toBeInstanceOf(Bridge::class);
});

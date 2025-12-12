<?php

declare(strict_types=1);

use Danielgnh\PolymarketLaravel\Facades\Polymarket;
use Danielgnh\PolymarketPhp\Client;

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

    expect($gamma)->toBeInstanceOf(\Danielgnh\PolymarketPhp\Gamma::class);
});

it('provides access to clob api through facade', function () {
    $clob = Polymarket::clob();

    expect($clob)->toBeInstanceOf(\Danielgnh\PolymarketPhp\Clob::class);
});

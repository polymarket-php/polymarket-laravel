<?php

declare(strict_types=1);

use Danielgnh\PolymarketPhp\Client;

it('registers the client as a singleton', function () {
    $client1 = app(Client::class);
    $client2 = app(Client::class);

    expect($client1)->toBe($client2);
});

it('resolves the client with correct configuration', function () {
    $client = app(Client::class);

    expect($client)->toBeInstanceOf(Client::class);
});

it('creates an alias for the client', function () {
    $clientByClass = app(Client::class);
    $clientByAlias = app('polymarket');

    expect($clientByAlias)->toBe($clientByClass);
});

it('merges default configuration', function () {
    $gammaUrl = config('polymarket.gamma_base_url');
    $clobUrl = config('polymarket.clob_base_url');
    $timeout = config('polymarket.timeout');
    $retries = config('polymarket.retries');

    expect($gammaUrl)->toBe('https://gamma-api.polymarket.com')
        ->and($clobUrl)->toBe('https://clob.polymarket.com')
        ->and($timeout)->toBe(15)
        ->and($retries)->toBe(2);
});

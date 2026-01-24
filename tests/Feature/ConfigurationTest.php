<?php

declare(strict_types=1);

it('has the correct default values', function () {
    expect(config('polymarket.gamma_base_url'))->toBe('https://gamma-api.polymarket.com')
        ->and(config('polymarket.clob_base_url'))->toBe('https://clob.polymarket.com')
        ->and(config('polymarket.bridge_base_url'))->toBe('https://bridge-api.polymarket.com')
        ->and(config('polymarket.timeout'))->toBe(15)
        ->and(config('polymarket.retries'))->toBe(2)
        ->and(config('polymarket.verify_ssl'))->toBeTrue()
        ->and(config('polymarket.chain_id'))->toBe(137);
});

it('allows nullable api_key', function () {
    config(['polymarket.api_key' => null]);

    expect(config('polymarket.api_key'))->toBeNull();
});

it('allows nullable private_key', function () {
    config(['polymarket.private_key' => null]);

    expect(config('polymarket.private_key'))->toBeNull();
});

it('timeout is cast to integer from env', function () {
    expect(config('polymarket.timeout'))->toBeInt();
});

it('retries is cast to integer from env', function () {
    expect(config('polymarket.retries'))->toBeInt();
});

it('chain_id is cast to integer from env', function () {
    expect(config('polymarket.chain_id'))->toBeInt();
});

it('can override configuration values', function () {
    config([
        'polymarket.api_key' => 'custom-api-key',
        'polymarket.timeout' => 60,
        'polymarket.gamma_base_url' => 'https://custom-gamma.com',
        'polymarket.bridge_base_url' => 'https://custom-bridge.com',
    ]);

    expect(config('polymarket.api_key'))->toBe('custom-api-key')
        ->and(config('polymarket.timeout'))->toBe(60)
        ->and(config('polymarket.gamma_base_url'))->toBe('https://custom-gamma.com')
        ->and(config('polymarket.bridge_base_url'))->toBe('https://custom-bridge.com');
});

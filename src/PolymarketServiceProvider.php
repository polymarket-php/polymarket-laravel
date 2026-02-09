<?php

declare(strict_types=1);

namespace PolymarketPhp\PolymarketLaravel;

use Illuminate\Foundation\Console\AboutCommand;
use PolymarketPhp\Polymarket\Client;
use PolymarketPhp\PolymarketLaravel\Commands\PolymarketInstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PolymarketServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('polymarket')
            ->hasConfigFile()
            ->hasCommand(PolymarketInstallCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $config = $app->make('config');

            return new Client(
                apiKey: $config->get('polymarket.api_key'),
                options: [
                    'gamma_base_url' => $config->get('polymarket.gamma_base_url'),
                    'clob_base_url' => $config->get('polymarket.clob_base_url'),
                    'bridge_base_url' => $config->get('polymarket.bridge_base_url'),
                    'timeout' => $config->get('polymarket.timeout'),
                    'retries' => $config->get('polymarket.retries'),
                    'verify_ssl' => $config->get('polymarket.verify_ssl'),
                    'private_key' => $config->get('polymarket.private_key'),
                    'chain_id' => $config->get('polymarket.chain_id'),
                ]
            );
        });

        $this->app->alias(Client::class, 'polymarket');
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            AboutCommand::add('Polymarket', fn () => [
                'API Key Configured' => config('polymarket.api_key') ? '✓' : '✗',
                'Private Key Configured' => config('polymarket.private_key') ? '✓' : '✗',
                'Gamma URL' => config('polymarket.gamma_base_url'),
                'CLOB URL' => config('polymarket.clob_base_url'),
                'Bridge URL' => config('polymarket.bridge_base_url'),
            ]);
        }
    }
}

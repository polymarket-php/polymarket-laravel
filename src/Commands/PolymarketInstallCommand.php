<?php

declare(strict_types=1);

namespace PolymarketPhp\PolymarketLaravel\Commands;

use Illuminate\Console\Command;

class PolymarketInstallCommand extends Command
{
    protected $signature = 'polymarket:install';

    protected $description = 'Install and configure the Polymarket Laravel package';

    public function handle(): int
    {
        $this->components->info('Installing Polymarket Laravel...');

        $this->call('vendor:publish', [
            '--tag' => 'polymarket-config',
        ]);

        $this->newLine();
        $this->components->info('Configuration published successfully!');
        $this->newLine();

        if (file_exists(base_path('.env'))) {
            $this->components->warn('Add your Polymarket credentials to your .env file:');
            $this->newLine();
            $this->line('  <fg=gray>POLYMARKET_API_KEY=</><fg=yellow>your-api-key</>');
            $this->line('  <fg=gray>POLYMARKET_PRIVATE_KEY=</><fg=yellow>0x...</>');
            $this->line('  <fg=gray>POLYMARKET_CHAIN_ID=</><fg=yellow>137</>');
            $this->newLine();
            $this->components->info('For read-only access to market data (Gamma API), credentials are optional.');
            $this->components->info('For trading operations (CLOB API), you must provide both API_KEY and PRIVATE_KEY.');
        }

        $this->newLine();
        $this->components->info('Polymarket Laravel installed successfully!');

        return self::SUCCESS;
    }
}

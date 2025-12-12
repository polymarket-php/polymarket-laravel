# Polymarket Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielgnh/polymarket-laravel.svg?style=flat-square)](https://packagist.org/packages/danielgnh/polymarket-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/danielgnh/polymarket-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/danielgnh/polymarket-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/danielgnh/polymarket-laravel.svg?style=flat-square)](https://packagist.org/packages/danielgnh/polymarket-laravel)

This is a Laravel adapter for the [Polymarket PHP SDK](https://github.com/danielgnh/polymarket-php), providing easy ways to integrate polymarket in your Laravel application.

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x

## Installation

You can install the package via Composer:

```bash
composer require danielgnh/polymarket-laravel
```

### Quick Setup

Run the install command for guided setup:

```bash
php artisan polymarket:install
```

This will:
- Publish the configuration file
- Display instructions for adding credentials to your `.env` file

### Manual Setup

Alternatively, you can publish the configuration file manually:

```bash
php artisan vendor:publish --tag="polymarket-config"
```

## Configuration

Add your Polymarket credentials to your `.env` file:

```env
POLYMARKET_API_KEY=your-api-key
POLYMARKET_PRIVATE_KEY=0x...
POLYMARKET_CHAIN_ID=137
```

### Configuration Options

All configuration options can be customized in `config/polymarket.php`:

| Option | Environment Variable | Default | Description |
|--------|---------------------|---------|-------------|
| `api_key` | `POLYMARKET_API_KEY` | `null` | API key for authenticated requests (optional for read-only) |
| `private_key` | `POLYMARKET_PRIVATE_KEY` | `null` | Private key for trading operations |
| `chain_id` | `POLYMARKET_CHAIN_ID` | `137` | Blockchain network (137 = Polygon mainnet) |
| `gamma_base_url` | `POLYMARKET_GAMMA_BASE_URL` | `https://gamma-api.polymarket.com` | Gamma API base URL |
| `clob_base_url` | `POLYMARKET_CLOB_BASE_URL` | `https://clob.polymarket.com` | CLOB API base URL |
| `timeout` | `POLYMARKET_TIMEOUT` | `30` | Request timeout in seconds |
| `retries` | `POLYMARKET_RETRIES` | `3` | Number of retry attempts |
| `verify_ssl` | `POLYMARKET_VERIFY_SSL` | `true` | Enable SSL certificate verification |

## Usage

### Using the Facade

The facade provides convenient static access to the Polymarket client:

```php
use Danielgnh\PolymarketLaravel\Facades\Polymarket;

// Fetch markets
$markets = Polymarket::gamma()->markets()->all();

// Search for specific markets
$markets = Polymarket::gamma()->markets()->search('election');

// Get a specific market
$market = Polymarket::gamma()->markets()->get('market-id');
```

### Dependency Injection

Inject the client directly into your classes:

```php
use Danielgnh\PolymarketPhp\Client;

class MarketController extends Controller
{
    public function __construct(
        private Client $polymarket
    ) {}

    public function index()
    {
        $markets = $this->polymarket->gamma()->markets()->all();

        return view('markets.index', compact('markets'));
    }

    public function show(string $id)
    {
        $market = $this->polymarket->gamma()->markets()->get($id);

        return view('markets.show', compact('market'));
    }
}
```

## Trading Operations (CLOB API)

For trading operations, you need to configure both an API key and private key:

```php
use Danielgnh\PolymarketLaravel\Facades\Polymarket;

// Authenticate for trading
Polymarket::auth();

// Place an order
$order = Polymarket::clob()->orders()->create([
    'market' => 'market-id',
    'side' => 'BUY',
    'price' => 0.5,
    'size' => 100,
]);

// Get your orders
$orders = Polymarket::clob()->orders()->list();

// Cancel an order
Polymarket::clob()->orders()->cancel($orderId);
```

## Market Data Examples

### Fetching All Markets

```php
use Danielgnh\PolymarketLaravel\Facades\Polymarket;

// Get all markets with pagination
$markets = Polymarket::gamma()->markets()->all([
    'limit' => 20,
    'offset' => 0,
]);

foreach ($markets as $market) {
    echo $market['question'] . PHP_EOL;
}
```

### Searching Markets

```php
// Search for election-related markets
$results = Polymarket::gamma()->markets()->search('election', [
    'limit' => 10,
]);

// Search with filters
$results = Polymarket::gamma()->markets()->search('crypto', [
    'active' => true,
    'closed' => false,
]);
```

### Getting Market Details

```php
$marketId = 'some-market-id';
$market = Polymarket::gamma()->markets()->get($marketId);

echo "Question: {$market['question']}" . PHP_EOL;
echo "Volume: {$market['volume']}" . PHP_EOL;
echo "Liquidity: {$market['liquidity']}" . PHP_EOL;
```

## Error Handling

The SDK throws specific exceptions for different error scenarios:

```php
use Danielgnh\PolymarketPhp\Exceptions\AuthenticationException;
use Danielgnh\PolymarketPhp\Exceptions\NotFoundException;
use Danielgnh\PolymarketPhp\Exceptions\RateLimitException;
use Danielgnh\PolymarketPhp\Exceptions\ValidationException;
use Danielgnh\PolymarketLaravel\Facades\Polymarket;

try {
    $market = Polymarket::gamma()->markets()->get($marketId);
} catch (NotFoundException $e) {
    // Market not found
    return response()->json(['error' => 'Market not found'], 404);
} catch (RateLimitException $e) {
    // Rate limit exceeded
    return response()->json(['error' => 'Too many requests'], 429);
} catch (AuthenticationException $e) {
    // Authentication failed
    return response()->json(['error' => 'Unauthorized'], 401);
} catch (ValidationException $e) {
    // Invalid request parameters
    return response()->json(['error' => $e->getMessage()], 422);
}
```

## Testing

The package includes comprehensive tests:

```bash
# Run tests
composer test

# Run static analysis
composer analyse

# Fix code style
composer format
```

### Mocking in Your Tests

You can easily mock the Polymarket client in your tests:

```php
use Danielgnh\PolymarketPhp\Client;
use Danielgnh\PolymarketLaravel\Facades\Polymarket;

public function test_it_fetches_markets()
{
    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('gamma->markets->all')
        ->once()
        ->andReturn(['market1', 'market2']);

    $this->app->instance(Client::class, $mockClient);

    // Your test code...
}
```

## Advanced Configuration

### Custom Timeouts

For long-running operations, adjust the timeout:

```env
POLYMARKET_TIMEOUT=60
```

### Retry Configuration

Configure automatic retry behavior:

```env
POLYMARKET_RETRIES=5
```

### Local Development

Disable SSL verification for local testing (not recommended for production):

```env
POLYMARKET_VERIFY_SSL=false
```

### Custom API URLs

Use custom API endpoints (useful for testing):

```env
POLYMARKET_GAMMA_BASE_URL=https://custom-gamma-api.example.com
POLYMARKET_CLOB_BASE_URL=https://custom-clob-api.example.com
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on recent changes.

## Contributing

Contributions are welcome! In case if you found any bug or have an idea just open an issue and create a Pull Request.

## Security

If you discover any security-related issues, please email security@example.com instead of using the issue tracker.

## Credits

- [Daniel Goncharov](https://github.com/danielgnh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

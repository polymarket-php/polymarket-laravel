<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Polymarket API Key
    |--------------------------------------------------------------------------
    |
    | Your Polymarket API key for authenticated requests to the CLOB API.
    | This is optional if you only need read-only access to market data
    | through the Gamma API. Set this in your .env file.
    |
    */

    'api_key' => env('POLYMARKET_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | Your private key for cryptographic operations with the CLOB API.
    | Required for order placement and other trading operations.
    | This should be a hex-encoded private key (starting with 0x).
    |
    */

    'private_key' => env('POLYMARKET_PRIVATE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Chain ID
    |--------------------------------------------------------------------------
    |
    | The blockchain network chain ID. Default is 137 for Polygon mainnet.
    | Change this only if you're using a different network (e.g., testnet).
    |
    */

    'chain_id' => (int) env('POLYMARKET_CHAIN_ID', 137),

    /*
    |--------------------------------------------------------------------------
    | Gamma API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Polymarket Gamma API (market data).
    | This API provides read-only access to market information, events,
    | and historical data. You typically won't need to change this.
    |
    */

    'gamma_base_url' => env('POLYMARKET_GAMMA_BASE_URL', 'https://gamma-api.polymarket.com'),

    /*
    |--------------------------------------------------------------------------
    | CLOB API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Polymarket CLOB API (trading operations).
    | This API handles order placement, cancellation, and other trading
    | activities. You typically won't need to change this.
    |
    */

    'clob_base_url' => env('POLYMARKET_CLOB_BASE_URL', 'https://clob.polymarket.com'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The maximum number of seconds to wait for API responses before timing
    | out. Increase this value if you're experiencing timeout errors, or
    | decrease it for faster failure detection.
    |
    */

    'timeout' => (int) env('POLYMARKET_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Retry Attempts
    |--------------------------------------------------------------------------
    |
    | The number of times to retry failed requests before giving up.
    | The SDK will automatically retry transient failures like network
    | errors or rate limiting.
    |
    */

    'retries' => (int) env('POLYMARKET_RETRIES', 3),

    /*
    |--------------------------------------------------------------------------
    | SSL Verification
    |--------------------------------------------------------------------------
    |
    | Whether to verify SSL certificates when making API requests.
    | Should always be true in production. Only set to false for local
    | development or testing purposes.
    |
    */

    'verify_ssl' => env('POLYMARKET_VERIFY_SSL', true),

];

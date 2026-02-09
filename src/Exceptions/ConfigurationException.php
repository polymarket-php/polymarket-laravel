<?php

declare(strict_types=1);

namespace PolymarketPhp\PolymarketLaravel\Exceptions;

use RuntimeException;

class ConfigurationException extends RuntimeException
{
    public static function missingApiKey(): self
    {
        return new self(
            'Polymarket API key is not configured. '.
            'Please set POLYMARKET_API_KEY in your .env file or publish the config file.'
        );
    }

    public static function missingPrivateKey(): self
    {
        return new self(
            'Polymarket private key is not configured. '.
            'Please set POLYMARKET_PRIVATE_KEY in your .env file. '.
            'This is required for trading operations (CLOB API).'
        );
    }

    public static function invalidConfiguration(string $key, string $message): self
    {
        return new self(
            "Invalid Polymarket configuration for '{$key}': {$message}"
        );
    }
}

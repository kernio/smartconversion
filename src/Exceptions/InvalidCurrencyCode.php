<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class InvalidCurrencyCode extends RuntimeException
{
    public static function invalidOrNotSupportedCurrencyCode(string $currencyCode): self
    {
        return new self(sprintf('Currency code [%s] is invalid or not supported', $currencyCode));
    }
}

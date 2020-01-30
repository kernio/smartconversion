<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class FailedCachedException extends RuntimeException
{
    public static function failAccessCachedCurrencyRate(string $currencyCode): self
    {
        return new self(sprintf('Failed access cached currency exchange rates for [%s] base currency', $currencyCode));
    }
}

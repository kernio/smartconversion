<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class OpenExchangeRatesFailedApiRequest extends RuntimeException
{
    public static function missedRatesInResponse(): self
    {
        return new self('Request to Fixer.io failed. Missed `rates` key in response');
    }
}

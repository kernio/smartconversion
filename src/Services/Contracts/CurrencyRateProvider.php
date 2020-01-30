<?php

declare(strict_types=1);

namespace App\Services\Contracts;

interface CurrencyRateProvider
{
    public function getLatestRates(string $baseCurrency): array;
}

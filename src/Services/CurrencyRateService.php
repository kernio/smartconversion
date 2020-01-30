<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidCurrencyCode;
use App\Services\Contracts\CurrencyRateProvider;

class CurrencyRateService
{
    private $currencyRateProvider;

    public function __construct(CurrencyRateProvider $currencyRateProvider)
    {
        $this->currencyRateProvider = $currencyRateProvider;
    }

    public function getCurrencyRate($originalCurrency, $targetCurrency): float
    {
        $currencyRates = $this->currencyRateProvider->getLatestRates($targetCurrency);

        if (!isset($currencyRates[$originalCurrency])) {
            throw InvalidCurrencyCode::invalidOrNotSupportedCurrencyCode($originalCurrency);
        }

        return $currencyRates[$originalCurrency];
    }
}

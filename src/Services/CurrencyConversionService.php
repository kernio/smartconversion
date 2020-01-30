<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Price;

class CurrencyConversionService
{
    private $currencyRateService;

    public function __construct(CurrencyRateService $currencyRateService)
    {
        $this->currencyRateService = $currencyRateService;
    }

    public function convert(Price $sourcePrice, string $outputCurrency): Price
    {
        $rate = $this->currencyRateService->getCurrencyRate($sourcePrice->getCurrency(), $outputCurrency);

        return Price::create($sourcePrice->getAmount() / $rate, $outputCurrency);
    }
}

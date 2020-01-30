<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTO\Price;
use App\Services\CurrencyConversionService;
use App\Services\CurrencyRateService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CurrencyConversionServiceTest extends TestCase
{
    /** @dataProvider provideTestData */
    public function testGetPriceInTargetCurrency(
        float $value,
        string $sourceCurrency,
        string $targetCurrency,
        float $rate,
        float $expectedValue
    ): void {
        /** @var CurrencyRateService|MockObject $currencyRateService */
        $currencyRateService = $this->createConfiguredMock(CurrencyRateService::class, ['getCurrencyRate' => $rate]);

        $service = new CurrencyConversionService($currencyRateService);
        $convertedPrice = $service->convert(Price::create($value, $sourceCurrency), $targetCurrency);

        $this->assertEquals(
            $expectedValue,
            $convertedPrice->getAmount()
        );
        $this->assertEquals(
            $targetCurrency,
            $convertedPrice->getCurrency()
        );
    }

    public function provideTestData(): array
    {
        return [
            [
                12.0,
                'USD',
                'EUR',
                1.1234,
                round(12.0 / 1.1234, 2),
            ],
        ];
    }
}

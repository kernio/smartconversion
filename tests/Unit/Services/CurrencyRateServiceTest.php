<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\Contracts\CurrencyRateProvider;
use App\Services\CurrencyRateService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CurrencyRateServiceTest extends TestCase
{
    /** @dataProvider provideTestData */
    public function testGetCurrencyRate(
        string $originCurrency,
        string $targetCurrency,
        float $currencyRate
    ): void {
        /** @var CurrencyRateProvider|MockObject $currencyRateProvider */
        $currencyRateProvider = $this->createMock(CurrencyRateProvider::class);

        $currencyRates = [$originCurrency => $currencyRate];
        $currencyRateProvider
            ->expects($this->once())
            ->method('getLatestRates')
            ->with($targetCurrency)
            ->willReturn($currencyRates);

        $service = new CurrencyRateService($currencyRateProvider);
        $this->assertEquals(
            $currencyRate,
            $service->getCurrencyRate($originCurrency, $targetCurrency)
        );
    }

    public function provideTestData(): array
    {
        return [
            [
                'USD',
                'EUR',
                1.1234,
            ],
        ];
    }
}

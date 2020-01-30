<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use App\DTO\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    /** @dataProvider provideTestData */
    public function testPrice(
        float $amount,
        string $currency,
        float $expectedPrice
    ): void {
        $checkoutPrice = Price::create($amount, $currency);

        $this->assertEquals($expectedPrice, $checkoutPrice->getAmount());
        $this->assertEquals($currency, $checkoutPrice->getCurrency());
    }

    public function provideTestData(): array
    {
        return [
            [123.34, 'USD', 123.34],
            [123.346, 'EUR', 123.35],
            [13.341, 'EUR', 13.34],
        ];
    }
}

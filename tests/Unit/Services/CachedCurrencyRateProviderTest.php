<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\CachedCurrencyRateProvider;
use App\Services\Contracts\CurrencyRateProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

class CachedCurrencyRateProviderTest extends TestCase
{
    public function testCurrencyRatesNotInCache(): void
    {
        $currency = 'USD';
        $rates = ['EUR' => 11.0, 'USD' => 1];

        /** @var CurrencyRateProvider|MockObject $currencyRateProvider */
        $currencyRateProvider = $this->createMock(CurrencyRateProvider::class);

        $currencyRateProvider->expects($this->once())->method('getLatestRates')->with($currency)->willReturn($rates);

        /** @var MockObject|AdapterInterface $cache */
        $cache = $this->createMock(AdapterInterface::class);

        $emptyCacheItem = new CacheItem();

        $cache->method('getItem')->with('currency_rate_USD')->willReturn($emptyCacheItem);
        $cache->method('hasItem')->with('currency_rate_USD')->willReturn(true);

        $service = new CachedCurrencyRateProvider($cache, $currencyRateProvider);

        $this->assertEquals($rates, $service->getLatestRates($currency));
        $this->assertEquals($rates, $emptyCacheItem->get());
    }

    public function testCurrencyInCache(): void
    {
        $currency = 'USD';
        $rates = ['EUR' => 11.0, 'USD' => 1];

        /** @var CurrencyRateProvider|MockObject $currencyRateProvider */
        $currencyRateProvider = $this->createMock(CurrencyRateProvider::class);

        $currencyRateProvider->expects($this->never())->method('getLatestRates');

        /** @var MockObject|AdapterInterface $cache */
        $cache = $this->createMock(AdapterInterface::class);

        $cacheItemWithItems = new CacheItem();
        $cacheItemWithItems->set($rates);

        $reflection = new ReflectionClass($cacheItemWithItems);
        $reflectionProperty = $reflection->getProperty('isHit');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($cacheItemWithItems, true);

        $cache->method('getItem')->with('currency_rate_USD')->willReturn($cacheItemWithItems);
        $cache->method('hasItem')->with('currency_rate_USD')->willReturn(true);

        $service = new CachedCurrencyRateProvider($cache, $currencyRateProvider);

        $this->assertEquals($rates, $service->getLatestRates($currency));
        $this->assertEquals($rates, $cacheItemWithItems->get());
    }
}

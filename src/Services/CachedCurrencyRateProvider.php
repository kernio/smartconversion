<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FailedCachedException;
use App\Services\Contracts\CurrencyRateProvider;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class CachedCurrencyRateProvider implements CurrencyRateProvider
{
    private const CACHE_PREFIX = 'currency_rate_';

    private $cache;
    private $provider;

    public function __construct(AdapterInterface $cache, CurrencyRateProvider $provider)
    {
        $this->cache = $cache;
        $this->provider = $provider;
    }

    public function getLatestRates(string $baseCurrency): array
    {
        $cacheKey = self::CACHE_PREFIX . $baseCurrency;
        $rates = $this->cache->getItem($cacheKey);

        if (!$rates->isHit()) {
            $rates->set($this->provider->getLatestRates($baseCurrency));
            $this->cache->save($rates);
        }

        if (!$this->cache->hasItem($cacheKey)) {
            throw FailedCachedException::failAccessCachedCurrencyRate($baseCurrency);
        }

        return $this->cache->getItem($cacheKey)->get();
    }
}

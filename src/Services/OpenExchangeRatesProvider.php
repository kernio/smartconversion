<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidCurrencyCode;
use App\Exceptions\OpenExchangeRatesFailedApiRequest;
use App\Services\Contracts\CurrencyRateProvider;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class OpenExchangeRatesProvider implements CurrencyRateProvider
{
    private const LATEST_RATES_ENDPOINT = '/latest.json';
    private const SUPPORTED_BASE_CURRENCY = 'USD';

    private $client;
    private $apiKey;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getLatestRates(string $baseCurrency): array
    {
        $response = $this->client
            ->get(
                self::LATEST_RATES_ENDPOINT,
                [
                    RequestOptions::QUERY => [
                        'app_id' => $this->apiKey,
                        'base' => self::SUPPORTED_BASE_CURRENCY
                    ],
                ]
            )
            ->getBody();

        $serviceResponse = json_decode((string)$response, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($serviceResponse['rates'])) {
            throw OpenExchangeRatesFailedApiRequest::missedRatesInResponse();
        }

        if (!isset($serviceResponse['rates'][$baseCurrency])) {
            throw InvalidCurrencyCode::invalidOrNotSupportedCurrencyCode($baseCurrency);
        }

        if ($baseCurrency === self::SUPPORTED_BASE_CURRENCY) {
            return $serviceResponse['rates'];
        }

        // OpenExchangeRatesProvider in free plan support only USD as base currency, convert manually
        return $this->adjustRatesToCorrectBaseCurrency($serviceResponse['rates'], $baseCurrency);
    }

    private function adjustRatesToCorrectBaseCurrency($rates, string $baseCurrency): array
    {
        $convertedRates = [];

        foreach ($rates as $currency => $rate) {
            $convertedRates[$currency] = $rate / $rates[$baseCurrency];
        }

        return $convertedRates;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\OpenExchangeRatesProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class OpenExchangeRatesProviderTest extends TestCase
{
    public function testRequestDetails(): void
    {
        $container = [];

        $history = Middleware::history($container);

        $client = $this->getGuzzleClient($history);
        $apiKey = 'test-123';
        $currency = 'EUR';

        $service = new OpenExchangeRatesProvider($client, $apiKey);
        $this->assertEquals(['EUR' => 1, 'USD' => 1 / 0.907892], $service->getLatestRates($currency));
        $this->assertCount(1, $container);
        $this->assertEquals('GET', $container[0]['request']->getMethod());
        $this->assertEquals('/latest.json', $container[0]['request']->getUri()->getPath());
        $this->assertEquals(
            sprintf('app_id=%s&base=%s', $apiKey, 'USD'), // base always USD, even if we provide EUR
            $container[0]['request']->getUri()->getQuery()
        );
    }

    private function getGuzzleClient($history): Client
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    [],
                    '{
                            "disclaimer": "Usage subject to terms: https://openexchangerates.org/terms",
                            "license": "https://openexchangerates.org/license",
                            "timestamp": 1580382000,
                            "base": "USD",
                            "rates":{"EUR":0.907892,"USD":1.00000}
                    }'
                ),
            ]
        );

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        return new Client(['handler' => $handlerStack]);
    }
}

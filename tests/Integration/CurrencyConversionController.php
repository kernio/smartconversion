<?php

declare(strict_types=1);

namespace Tests\Integration;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrencyConversionController extends WebTestCase
{
    private const API_ENDPOINT = '/api/converted-price/%s/%s/%s';

    /** @var KernelBrowser */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testRequestWithCorrectPayload(): void
    {
        $sourceCurrency = 'USD';
        $amount = 13.23;
        $outputCurrency = 'EUR';

        $this->client->request(
            'GET',
            sprintf(self::API_ENDPOINT, $sourceCurrency, $amount, $outputCurrency)
        );

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $decodedResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('amount', $decodedResponse);
        $this->assertArrayHasKey('currency', $decodedResponse);
        $this->assertEquals('EUR', $decodedResponse['currency']);
    }

    public function testRequestUnsupportedCurrency(): void
    {
        $sourceCurrency = 'USD';
        $amount = 13.23;
        $outputCurrency = 'PHP';

        $this->client->request(
            'GET',
            sprintf(self::API_ENDPOINT, $sourceCurrency, $amount, $outputCurrency)
        );

        $response = $this->client->getResponse();

        // Endpoint have a requirements of possible params, PHP currency is not in the list
        $this->assertEquals(404, $response->getStatusCode());
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\Price;
use App\Services\CurrencyConversionService;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyConversionController extends AbstractController
{
    private $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }

    /**
     * Convert price value from source currency to target
     *
     * @Route(
     *     "/api/converted-price/{sourceCurrency}/{sourceAmount}/{outputCurrency}",
     *     name="currency_conversion_convert",
     *     requirements={
     *          "sourceCurrency" = "(USD|EUR|JPY|CAD|GBP)",
     *          "sourceAmount" = "\d+(\.\d+)?",
     *          "outputCurrency" = "(USD|EUR|JPY|CAD|GBP)"
     *     },
     *     methods={"GET"},
     *     options={"expose"=true}
     * )
     *
     * @SWG\Parameter(
     *     name="sourceCurrency",
     *     in="path",
     *     type="string",
     *     required=true,
     *     type="string",
     *     description="Source Currency"
     * )
     *
     * @SWG\Parameter(
     *     name="sourceAmount",
     *     in="path",
     *     type="number",
     *     required=true,
     *     description="Source Amount"
     * )
     *
     * @SWG\Parameter(
     *     name="outputCurrency",
     *     in="path",
     *     type="string",
     *     required=true,
     *     type="string",
     *     description="Output Currency"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Result of converstion",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *             property="amount",
     *             type="number"
     *          ),
     *          @SWG\Property(
     *             property="currency",
     *             type="string"
     *          )
     *     )
     * )
     */
    public function convertedPriceAction(
        string $sourceCurrency,
        float $sourceAmount,
        string $outputCurrency
    ): JsonResponse {
        return $this->json(
            $this->currencyConversionService->convert(Price::create($sourceAmount, $sourceCurrency), $outputCurrency)
        );
    }
}

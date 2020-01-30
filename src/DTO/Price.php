<?php

declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;

class Price implements JsonSerializable
{
    private $amount;
    private $currency;

    private function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function create(float $amount, string $currency): Price
    {
        return new self($amount, $currency);
    }

    public function getAmount(): float
    {
        return round($this->amount, 2);
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
        ];
    }
}

<?php

namespace App\Interfaces;

interface CryptoPriceRepositoryInterface
{
    public function updateOrCreatePrice(string $currency, float $price);

    public function getPrices(?string $currency = null, ?string $from = null, ?string $to = null);
}

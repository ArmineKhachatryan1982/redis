<?php

namespace App\Services;

use App\Interfaces\CryptoPriceRepositoryInterface as InterfacesCryptoPriceRepositoryInterface;
use App\Repositories\CryptoPriceRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CryptoPriceService
{

    public function __construct( protected InterfacesCryptoPriceRepositoryInterface $repo){}

    public function getPrices(?string $currency, ?string $from, ?string $to)
    {
        $cacheKey = "prices:$currency:$from:$to";

        return Cache::remember($cacheKey, config('crypto.cache_ttl'), function () use ($currency, $from, $to) {
            return $this->repo->getPrices($currency, $from, $to);
        });
    }
}

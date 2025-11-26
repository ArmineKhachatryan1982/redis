<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinGeckoService
{
    public function getPrices(array $currencies)
    {
        $ids = implode(',', array_keys($currencies));

        return Http::retry(3, 2000) // 3 retries, backoff 2s
            ->get(config('crypto.api_url'), [
                'ids' => $ids,
                'vs_currencies' => 'usd'
            ])
            ->json();
    }
    
}

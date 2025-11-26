<?php

namespace App\Repositories;

use App\Interfaces\CryptoPriceRepositoryInterface;
use App\Models\CryptoPrice;
use Illuminate\Support\Facades\Log;

class CryptoPriceRepository implements CryptoPriceRepositoryInterface
{
    public function updateOrCreatePrice(string $currency, float $price)
    {
       Log::info('update');
        return CryptoPrice::updateOrCreate(
            ['currency' => $currency],
            [
                'price' => $price,
                'synced_at' => now()
            ]
        );
    }

    public function getPrices(?string $currency = null, ?string $from = null, ?string $to = null)
    {
        $query = CryptoPrice::query();

        if ($currency) {
            $query->where('currency', $currency);
        }

        if ($from) {
            $query->whereDate('synced_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('synced_at', '<=', $to);
        }

        return $query->get();
    }
}

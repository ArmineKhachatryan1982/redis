<?php

namespace App\Jobs;

use App\Interfaces\CryptoPriceRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CryptoPriceSyncJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3; // сколько раз будет пытаться выполнить
    public $backoff = [1, 2, 4]; // 1s → 2s → 4s backoff

    protected $cryptoRepository;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CryptoPriceRepositoryInterface $cryptoRepository): void
    {
        $this->cryptoRepository = $cryptoRepository;

        try {
             $currencies = array_keys(config('crypto.currencies')); // ['bitcoin', 'ethereum']
            log::info('Cripto currency',['currency'=>$currencies]);

            $apiUrl   = config('crypto.api_url');
            $vsCurrency = config('crypto.vs_currency');
            Log::info('Crypto vsCurrency Data', ['vsCurrency' =>$vsCurrency]);

            $response = Http::retry(3, 500)->get($apiUrl, [
                'ids' => implode(',', $currencies),
                'vs_currencies' => $vsCurrency
            ]);

            if ($response->failed()) {
                Log::error('Crypto Sync Failed: API error', ['response' => $response->body()]);
                return;
            }

            $prices = $response->json(); // пример: ['bitcoin' => ['usd' => 43920]]
Log::info('Crypto Job Data', ['prices' => $prices]);
            foreach ($prices as $coin => $data) {
                $price = $data[$vsCurrency] ?? null;

                if ($price) {
                    $this->cryptoRepository->updateOrCreatePrice($coin, $price);
                }
            }

            Log::info('Crypto Sync Success', ['data' => $prices]);

        } catch (\Exception $e) {
            Log::error('Crypto Sync Exception', ['error' => $e->getMessage()]);
        }
    }
}

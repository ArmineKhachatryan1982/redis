<?php

use App\Http\Controllers\CriptoPriceController;
use App\Interfaces\CryptoPriceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/prices', function (CryptoPriceRepositoryInterface $repo) {
//     $currency = request('currency');
//     $from = request('from_date');
//     $to = request('to_date');

//     $cacheKey = "prices:$currency:$from:$to";

//     return Cache::remember($cacheKey, config('crypto.cache_ttl'), function () use ($repo, $currency, $from, $to) {
//         return $repo->getPrices($currency, $from, $to);
//     });
// });

Route::get('price',[CriptoPriceController::class,'index']);



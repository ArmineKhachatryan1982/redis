<?php

namespace App\Http\Controllers;

use App\Interfaces\CryptoPriceRepositoryInterface;
use App\Services\CryptoPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CriptoPriceController extends Controller
{
    public function __construct(protected CryptoPriceService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currency = $request->query('currency');
        $from = $request->query('from_date');
        $to = $request->query('to_date');

        return response()->json($this->service->getPrices($currency, $from, $to));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

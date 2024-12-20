<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\Currency\StoreCurrencyRequest;
use Dearpos\Core\Http\Requests\Currency\UpdateCurrencyRequest;
use Dearpos\Core\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CurrencyController extends Controller
{
    public function index(): JsonResponse
    {
        $currencies = Currency::all();

        return response()->json($currencies);
    }

    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        $currency = Currency::create($request->validated());

        return response()->json($currency, 201);
    }

    public function show(Currency $currency): JsonResponse
    {
        return response()->json($currency);
    }

    public function update(UpdateCurrencyRequest $request, Currency $currency): JsonResponse
    {
        $currency->update($request->validated());

        return response()->json($currency);
    }

    public function destroy(Currency $currency): JsonResponse
    {
        $currency->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\Currency\StoreCurrencyRequest;
use Dearpos\Core\Http\Requests\Currency\UpdateCurrencyRequest;
use Dearpos\Core\Models\Currency;
use Dearpos\Core\Resources\CurrencyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CurrencyController extends Controller
{
    public function index(): JsonResponse
    {
        $currencies = Currency::withoutTrashed()->paginate();

        return response()->json([
            'data' => CurrencyResource::collection($currencies),
            'links' => [
                'first' => $currencies->url(1),
                'last' => $currencies->url($currencies->lastPage()),
                'prev' => $currencies->previousPageUrl(),
                'next' => $currencies->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $currencies->currentPage(),
                'last_page' => $currencies->lastPage(),
                'per_page' => $currencies->perPage(),
                'total' => $currencies->total(),
            ],
        ]);
    }

    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        $currency = Currency::create($request->validated());

        return response()->json([
            'data' => new CurrencyResource($currency),
        ], 201);
    }

    public function show(Currency $currency): JsonResponse
    {
        return response()->json([
            'data' => new CurrencyResource($currency),
        ]);
    }

    public function update(UpdateCurrencyRequest $request, Currency $currency): JsonResponse
    {
        $currency->update($request->validated());

        return response()->json([
            'data' => new CurrencyResource($currency->fresh()),
        ]);
    }

    public function destroy(Currency $currency): JsonResponse
    {
        $currency->delete();

        return response()->json(null, 204);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route('currency')) {
                $currency = Currency::withoutTrashed()->findOrFail($request->route('currency'));
                $request->route()->setParameter('currency', $currency);
            }

            return $next($request);
        })->only(['show', 'update', 'destroy']);
    }
}

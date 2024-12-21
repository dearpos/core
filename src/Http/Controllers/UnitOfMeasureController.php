<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\UnitOfMeasure\StoreUnitOfMeasureRequest;
use Dearpos\Core\Http\Requests\UnitOfMeasure\UpdateUnitOfMeasureRequest;
use Dearpos\Core\Models\UnitOfMeasure;
use Dearpos\Core\Resources\UnitOfMeasureResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UnitOfMeasureController extends Controller
{
    public function index(): JsonResponse
    {
        $units = UnitOfMeasure::withoutTrashed()->paginate();

        return response()->json([
            'data' => UnitOfMeasureResource::collection($units),
            'links' => [
                'first' => $units->url(1),
                'last' => $units->url($units->lastPage()),
                'prev' => $units->previousPageUrl(),
                'next' => $units->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $units->currentPage(),
                'last_page' => $units->lastPage(),
                'per_page' => $units->perPage(),
                'total' => $units->total(),
            ],
        ]);
    }

    public function store(StoreUnitOfMeasureRequest $request): JsonResponse
    {
        $unit = UnitOfMeasure::create($request->validated());

        return response()->json([
            'data' => new UnitOfMeasureResource($unit)
        ], 201);
    }

    public function show(UnitOfMeasure $unit): JsonResponse
    {
        return response()->json([
            'data' => new UnitOfMeasureResource($unit)
        ]);
    }

    public function update(UpdateUnitOfMeasureRequest $request, UnitOfMeasure $unit): JsonResponse
    {
        $unit->update($request->validated());

        return response()->json([
            'data' => new UnitOfMeasureResource($unit->fresh())
        ]);
    }

    public function destroy(UnitOfMeasure $unit): JsonResponse
    {
        $unit->delete();

        return response()->json(null, 204);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route('unit')) {
                $unit = UnitOfMeasure::withoutTrashed()->findOrFail($request->route('unit'));
                $request->route()->setParameter('unit', $unit);
            }

            return $next($request);
        })->only(['show', 'update', 'destroy']);
    }
}

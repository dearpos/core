<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\UnitOfMeasure\StoreUnitOfMeasureRequest;
use Dearpos\Core\Http\Requests\UnitOfMeasure\UpdateUnitOfMeasureRequest;
use Dearpos\Core\Models\UnitOfMeasure;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UnitOfMeasureController extends Controller
{
    public function index(): JsonResponse
    {
        $units = UnitOfMeasure::withoutTrashed()->get();

        return response()->json($units);
    }

    public function store(StoreUnitOfMeasureRequest $request): JsonResponse
    {
        $unit = UnitOfMeasure::create($request->validated());

        return response()->json($unit->fresh(), 201);
    }

    public function show(UnitOfMeasure $unit): JsonResponse
    {
        return response()->json($unit);
    }

    public function update(UpdateUnitOfMeasureRequest $request, UnitOfMeasure $unit): JsonResponse
    {
        $unit->update($request->validated());

        return response()->json($unit->fresh());
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

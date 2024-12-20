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
        $units = UnitOfMeasure::all();

        return response()->json($units);
    }

    public function store(StoreUnitOfMeasureRequest $request): JsonResponse
    {
        $unit = UnitOfMeasure::create($request->validated());

        return response()->json($unit, 201);
    }

    public function show(UnitOfMeasure $unitOfMeasure): JsonResponse
    {
        return response()->json($unitOfMeasure);
    }

    public function update(UpdateUnitOfMeasureRequest $request, UnitOfMeasure $unitOfMeasure): JsonResponse
    {
        $unitOfMeasure->update($request->validated());

        return response()->json($unitOfMeasure);
    }

    public function destroy(UnitOfMeasure $unitOfMeasure): JsonResponse
    {
        $unitOfMeasure->delete();

        return response()->json(null, 204);
    }
}

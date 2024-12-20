<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\Location\StoreLocationRequest;
use Dearpos\Core\Http\Requests\Location\UpdateLocationRequest;
use Dearpos\Core\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class LocationController extends Controller
{
    public function index(): JsonResponse
    {
        $locations = Location::all();

        return response()->json($locations);
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = Location::create($request->validated());

        return response()->json($location, 201);
    }

    public function show(Location $location): JsonResponse
    {
        return response()->json($location);
    }

    public function update(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $location->update($request->validated());

        return response()->json($location);
    }

    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return response()->json(null, 204);
    }
}

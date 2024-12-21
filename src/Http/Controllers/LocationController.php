<?php

namespace Dearpos\Core\Http\Controllers;

use Dearpos\Core\Http\Requests\Location\StoreLocationRequest;
use Dearpos\Core\Http\Requests\Location\UpdateLocationRequest;
use Dearpos\Core\Models\Location;
use Dearpos\Core\Resources\LocationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class LocationController extends Controller
{
    public function index(): JsonResponse
    {
        $locations = Location::withoutTrashed()->paginate();

        return response()->json([
            'data' => LocationResource::collection($locations),
            'meta' => [
                'current_page' => $locations->currentPage(),
                'last_page' => $locations->lastPage(),
                'per_page' => $locations->perPage(),
                'total' => $locations->total(),
            ],
            'links' => [
                'first' => $locations->url(1),
                'last' => $locations->url($locations->lastPage()),
                'prev' => $locations->previousPageUrl(),
                'next' => $locations->nextPageUrl(),
            ],
        ]);
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = Location::create($request->validated());

        return response()->json([
            'data' => new LocationResource($location)
        ], 201);
    }

    public function show(Location $location): JsonResponse
    {
        return response()->json([
            'data' => new LocationResource($location)
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $location->update($request->validated());

        return response()->json([
            'data' => new LocationResource($location->fresh())
        ]);
    }

    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return response()->json(null, 204);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route('location')) {
                $location = Location::withoutTrashed()->findOrFail($request->route('location'));
                $request->route()->setParameter('location', $location);
            }

            return $next($request);
        })->only(['show', 'update', 'destroy']);
    }
}

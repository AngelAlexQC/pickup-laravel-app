<?php

namespace App\Http\Controllers\Api;

use App\Models\Road;
use Illuminate\Http\Request;
use App\Http\Resources\RoadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoadCollection;
use App\Http\Requests\RoadStoreRequest;
use App\Http\Requests\RoadUpdateRequest;

class RoadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Road::class);

        $search = $request->get('search', '');

        $roads = Road::search($search)
            ->latest()
            ->paginate();

        return new RoadCollection($roads);
    }

    /**
     * @param \App\Http\Requests\RoadStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoadStoreRequest $request)
    {
        $this->authorize('create', Road::class);

        $validated = $request->validated();

        $road = Road::create($validated);

        return new RoadResource($road);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Road $road)
    {
        $this->authorize('view', $road);

        return new RoadResource($road);
    }

    /**
     * @param \App\Http\Requests\RoadUpdateRequest $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function update(RoadUpdateRequest $request, Road $road)
    {
        $this->authorize('update', $road);

        $validated = $request->validated();

        $road->update($validated);

        return new RoadResource($road);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Road $road)
    {
        $this->authorize('delete', $road);

        $road->delete();

        return response()->noContent();
    }
}

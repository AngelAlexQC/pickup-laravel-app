<?php

namespace App\Http\Controllers;

use App\Models\Road;
use App\Models\Address;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.roads.index', compact('roads', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Road::class);

        $addresses = Address::pluck('name', 'id');

        return view('app.roads.create', compact('addresses', 'addresses'));
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

        return redirect()
            ->route('roads.edit', $road)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Road $road)
    {
        $this->authorize('view', $road);

        return view('app.roads.show', compact('road'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Road $road)
    {
        $this->authorize('update', $road);

        $addresses = Address::pluck('name', 'id');

        return view(
            'app.roads.edit',
            compact('road', 'addresses', 'addresses')
        );
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

        return redirect()
            ->route('roads.edit', $road)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('roads.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Resources\RoadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoadCollection;

class AddressRoadsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Address $address)
    {
        $this->authorize('view', $address);

        $search = $request->get('search', '');

        $roads = $address
            ->end_address_of()
            ->search($search)
            ->latest()
            ->paginate();

        return new RoadCollection($roads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Address $address)
    {
        $this->authorize('create', Road::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'meta' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $road = $address->end_address_of()->create($validated);

        return new RoadResource($road);
    }
}

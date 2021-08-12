<?php

namespace App\Http\Controllers\Api;

use App\Models\Road;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCollection;

class RoadAddressesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Road $road)
    {
        $this->authorize('view', $road);

        $search = $request->get('search', '');

        $addresses = $road
            ->waypoints()
            ->search($search)
            ->latest()
            ->paginate();

        return new AddressCollection($addresses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Road $road)
    {
        $this->authorize('create', Address::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'meta' => ['required', 'max:255', 'string'],
        ]);

        $address = $road->waypoints()->create($validated);

        return new AddressResource($address);
    }
}

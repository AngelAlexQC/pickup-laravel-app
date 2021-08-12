<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCollection;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;

class AddressController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Address::class);

        $search = $request->get('search', '');

        $addresses = Address::search($search)
            ->latest()
            ->paginate();

        return new AddressCollection($addresses);
    }

    /**
     * @param \App\Http\Requests\AddressStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreRequest $request)
    {
        $this->authorize('create', Address::class);

        $validated = $request->validated();

        $address = Address::create($validated);

        return new AddressResource($address);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Address $address)
    {
        $this->authorize('view', $address);

        return new AddressResource($address);
    }

    /**
     * @param \App\Http\Requests\AddressUpdateRequest $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validated();

        $address->update($validated);

        return new AddressResource($address);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return response()->noContent();
    }
}

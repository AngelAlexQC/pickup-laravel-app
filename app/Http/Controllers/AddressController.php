<?php

namespace App\Http\Controllers;

use App\Models\Road;
use App\Models\Address;
use Illuminate\Http\Request;
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
            ->paginate(5);

        return view('app.addresses.index', compact('addresses', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Address::class);

        $roads = Road::pluck('name', 'id');

        return view('app.addresses.create', compact('roads'));
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

        return redirect()
            ->route('addresses.edit', $address)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Address $address)
    {
        $this->authorize('view', $address);

        return view('app.addresses.show', compact('address'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $roads = Road::pluck('name', 'id');

        return view('app.addresses.edit', compact('address', 'roads'));
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

        return redirect()
            ->route('addresses.edit', $address)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('addresses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}

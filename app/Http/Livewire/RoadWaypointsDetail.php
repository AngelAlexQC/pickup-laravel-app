<?php

namespace App\Http\Livewire;

use App\Models\Road;
use Livewire\Component;
use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoadWaypointsDetail extends Component
{
    use AuthorizesRequests;

    public Road $road;
    public Address $address;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Address';

    protected $rules = [
        'address.name' => ['required', 'max:255', 'string'],
        'address.address' => ['required', 'max:255', 'string'],
        'address.phone' => ['required', 'max:255', 'string'],
        'address.meta' => ['required', 'max:255', 'string'],
    ];

    public function mount(Road $road)
    {
        $this->road = $road;
        $this->resetAddressData();
    }

    public function resetAddressData()
    {
        $this->address = new Address();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAddress()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.road_waypoints.new_title');
        $this->resetAddressData();

        $this->showModal();
    }

    public function editAddress(Address $address)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.road_waypoints.edit_title');
        $this->address = $address;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->address->waypoint_road_id) {
            $this->authorize('create', Address::class);

            $this->address->waypoint_road_id = $this->road->id;
        } else {
            $this->authorize('update', $this->address);
        }

        $this->address->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Address::class);

        Address::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetAddressData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->road->addresses as $address) {
            array_push($this->selected, $address->id);
        }
    }

    public function render()
    {
        return view('livewire.road-waypoints-detail', [
            'addresses' => $this->road->addresses()->paginate(20),
        ]);
    }
}

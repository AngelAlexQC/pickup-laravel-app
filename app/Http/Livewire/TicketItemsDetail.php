<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Ticket;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketItemsDetail extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;
    public Item $item;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Item';

    protected $rules = [
        'item.name' => ['required', 'max:255', 'string'],
        'item.description' => ['required', 'max:255', 'string'],
        'item.meta' => ['nullable', 'max:255', 'string'],
        'item.price' => ['required', 'numeric'],
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->resetItemData();
    }

    public function resetItemData()
    {
        $this->item = new Item();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newItem()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.ticket_items.new_title');
        $this->resetItemData();

        $this->showModal();
    }

    public function editItem(Item $item)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.ticket_items.edit_title');
        $this->item = $item;

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

        if (!$this->item->track_id) {
            $this->authorize('create', Item::class);

            $this->item->track_id = $this->ticket->id;
        } else {
            $this->authorize('update', $this->item);
        }

        $this->item->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Item::class);

        Item::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetItemData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->ticket->items as $item) {
            array_push($this->selected, $item->id);
        }
    }

    public function render()
    {
        return view('livewire.ticket-items-detail', [
            'items' => $this->ticket->items()->paginate(20),
        ]);
    }
}

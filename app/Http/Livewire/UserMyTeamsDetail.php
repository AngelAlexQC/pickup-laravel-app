<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Team;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserMyTeamsDetail extends Component
{
    use AuthorizesRequests;

    public User $user;
    public Team $team;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Team';

    protected $rules = [
        'team.name' => ['required', 'max:255', 'string'],
        'team.slug' => ['required', 'max:255', 'string'],
        'team.address' => ['required', 'max:255', 'string'],
        'team.phone' => ['required', 'max:255', 'string'],
        'team.meta' => ['required', 'max:255', 'string'],
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->resetTeamData();
    }

    public function resetTeamData()
    {
        $this->team = new Team();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newTeam()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_my_teams.new_title');
        $this->resetTeamData();

        $this->showModal();
    }

    public function editTeam(Team $team)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_my_teams.edit_title');
        $this->team = $team;

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

        if (!$this->team->owner_id) {
            $this->authorize('create', Team::class);

            $this->team->owner_id = $this->user->id;
        } else {
            $this->authorize('update', $this->team);
        }

        $this->team->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Team::class);

        Team::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetTeamData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->teams as $team) {
            array_push($this->selected, $team->id);
        }
    }

    public function render()
    {
        return view('livewire.user-my-teams-detail', [
            'teams' => $this->user->teams()->paginate(20),
        ]);
    }
}

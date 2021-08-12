<div>
    <div>
        @can('create', App\Models\Team::class)
        <button class="button" wire:click="newTeam">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Team::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="team.name"
                            label="Name"
                            wire:model="team.name"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="team.slug"
                            label="Slug"
                            wire:model="team.slug"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="team.address"
                            label="Address"
                            wire:model="team.address"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="team.phone"
                            label="Phone"
                            wire:model="team.phone"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="team.meta"
                            label="Meta"
                            wire:model="team.meta"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @endif
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_my_teams.inputs.name')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_my_teams.inputs.slug')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_my_teams.inputs.address')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_my_teams.inputs.phone')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.user_my_teams.inputs.meta')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($teams as $team)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $team->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $team->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $team->slug ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $team->address ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $team->phone ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $team->meta ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $team)
                            <button
                                type="button"
                                class="button"
                                wire:click="editTeam({{ $team->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="mt-10 px-4">{{ $teams->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

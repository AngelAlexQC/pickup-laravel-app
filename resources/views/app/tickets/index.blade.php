<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.tickets.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Ticket::class)
                            <a
                                href="{{ route('tickets.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.sender_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.reciever_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.vehicle_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.driver_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.meta')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.tickets.inputs.price')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.datetime_start')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.tickets.inputs.datetime_end')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($ticket->sender)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($ticket->reciever)->name ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($ticket->vehicle)->name ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($ticket->driver)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $ticket->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $ticket->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $ticket->meta ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $ticket->price ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $ticket->datetime_start ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $ticket->datetime_end ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="relative inline-flex align-middle"
                                    >
                                        @can('update', $ticket)
                                        <a
                                            href="{{ route('tickets.edit', $ticket) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $ticket)
                                        <a
                                            href="{{ route('tickets.show', $ticket) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $ticket)
                                        <form
                                            action="{{ route('tickets.destroy', $ticket) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-trash text-red-600"
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="mt-10 px-4">
                                        {!! $tickets->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>

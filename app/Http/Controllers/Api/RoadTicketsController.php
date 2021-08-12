<?php
namespace App\Http\Controllers\Api;

use App\Models\Road;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketCollection;

class RoadTicketsController extends Controller
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

        $tickets = $road
            ->allTracks()
            ->search($search)
            ->latest()
            ->paginate();

        return new TicketCollection($tickets);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Road $road, Ticket $ticket)
    {
        $this->authorize('update', $road);

        $road->allTracks()->syncWithoutDetaching([$ticket->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Road $road
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Road $road, Ticket $ticket)
    {
        $this->authorize('update', $road);

        $road->allTracks()->detach($ticket);

        return response()->noContent();
    }
}

<?php
namespace App\Http\Controllers\Api;

use App\Models\Road;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoadCollection;

class TicketRoadsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $search = $request->get('search', '');

        $roads = $ticket
            ->roads()
            ->search($search)
            ->latest()
            ->paginate();

        return new RoadCollection($roads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket, Road $road)
    {
        $this->authorize('update', $ticket);

        $ticket->roads()->syncWithoutDetaching([$road->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @param \App\Models\Road $road
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ticket $ticket, Road $road)
    {
        $this->authorize('update', $ticket);

        $ticket->roads()->detach($road);

        return response()->noContent();
    }
}

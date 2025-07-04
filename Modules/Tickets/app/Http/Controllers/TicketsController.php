<?php

namespace Modules\Tickets\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use Modules\Tickets\Http\Requests\TicketStoreRequest;
use Modules\Tickets\Http\Resources\TicketResource;
use Modules\Tickets\Ticket;

class TicketsController extends Controller
{
    use AuthorizesRequests;

//    public function index()
//    {
//        $this->authorize('view', Ticket::class);
//
//        return TicketResource::collection(Ticket::all());
//    }

    public function create()
    {
        $this->authorize('create', Ticket::class);

        return Inertia::render('Tickets/Create', [
            'ticketPriorities' => [['name' => 'Low'], ['name' => 'Medium'], ['name' => 'High'], ['name' => 'Urgent']],
        ]);
    }

    public function store(TicketStoreRequest $request)
    {
        $this->authorize('create', Ticket::class);

        Ticket::create($request->validated());

        $request->session()->flash('message', 'Ticket created.');

        return to_route('tickets.create');
    }

//    public function show(Ticket $ticket)
//    {
//        $this->authorize('view', $ticket);
//
//        return new TicketResource($ticket);
//    }

//    public function update(TicketRequest $request, Ticket $ticket)
//    {
//        $this->authorize('update', $ticket);
//
//        $ticket->update($request->validated());
//
//        return new TicketResource($ticket);
//    }

//    public function destroy(Ticket $ticket)
//    {
//        $this->authorize('delete', $ticket);
//
//        $ticket->delete();
//
//        return response()->json();
//    }
}

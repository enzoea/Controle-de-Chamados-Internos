<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketCreationService;
use App\Services\TicketQueryService;
use App\Services\TicketUpdateService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(
        IndexTicketRequest $request,
        TicketQueryService $ticketQueryService,
    ): View {
        return view('tickets.index', [
            'tickets' => $ticketQueryService->paginate($request->validated()),
            'responsibleUsers' => $this->responsibleUsers(),
            'filters' => $request->validated(),
        ]);
    }

    public function create(): View
    {
        return view('tickets.create', [
            'responsibleUsers' => $this->responsibleUsers(),
        ]);
    }

    public function store(
        StoreTicketRequest $request,
        TicketCreationService $ticketCreationService,
    ): RedirectResponse {
        try {
            $ticketCreationService->create(
                requester: $request->user(),
                data: $request->validated(),
            );
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    'responsible_id' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Chamado aberto com sucesso.');
    }

    public function show(
        Ticket $ticket,
        TicketQueryService $ticketQueryService,
    ): View {
        return view('tickets.show', [
            'ticket' => $ticketQueryService->show($ticket),
        ]);
    }

    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', [
            'ticket' => $ticket,
            'responsibleUsers' => $this->responsibleUsers(),
        ]);
    }

    public function update(
        UpdateTicketRequest $request,
        Ticket $ticket,
        TicketUpdateService $ticketUpdateService,
    ): RedirectResponse {
        try {
            $ticketUpdateService->update(
                ticket: $ticket,
                data: $request->validated(),
            );
        } catch (DomainException $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    'responsible_id' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    /**
     * @return Collection<int, User>
     */
    private function responsibleUsers(): Collection
    {
        return User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }
}

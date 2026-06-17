<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\User;
use App\Services\TicketCreationService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function create(): View
    {
        $responsibleUsers = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('tickets.create', [
            'responsibleUsers' => $responsibleUsers,
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
}

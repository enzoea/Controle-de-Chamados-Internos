<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TicketQueryService
{
    /**
     * Retorna a listagem paginada de chamados com os filtros documentados.
     *
     * A consulta usa eager loading para evitar N+1 ao exibir solicitante
     * e responsavel na listagem e na visualizacao detalhada.
     *
     * @param array<string, mixed> $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        return Ticket::query()
            ->with([
                'requester:id,name,email',
                'responsible:id,name,email',
            ])
            ->when(
                filled($filters['status'] ?? null),
                fn ($query) => $query->where('status', $filters['status'])
            )
            ->when(
                filled($filters['priority'] ?? null),
                fn ($query) => $query->where('priority', $filters['priority'])
            )
            ->when(
                filled($filters['responsible_id'] ?? null),
                fn ($query) => $query->where('responsible_id', $filters['responsible_id'])
            )
            ->orderByDesc('opened_at')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Carrega os relacionamentos necessarios para a tela de detalhes do chamado.
     */
    public function show(Ticket $ticket): Ticket
    {
        return $ticket->load([
            'requester:id,name,email',
            'responsible:id,name,email',
        ]);
    }
}

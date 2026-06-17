<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\User;
use DomainException;

class TicketAssignmentService
{
    /**
     * Retorna o responsavel com menor quantidade de chamados em aberto.
     *
     * Considera como chamados em aberto os status ABERTO e EM_ANDAMENTO.
     * Em caso de empate, seleciona o usuario de menor ID.
     *
     * @throws DomainException
     */
    public function assignAutomatically(): User
    {
        $responsible = User::query()
            ->withCount([
                'assignedTickets as open_tickets_count' => fn ($query) => $query
                    ->whereIn('status', TicketStatus::openValues()),
            ])
            ->orderBy('open_tickets_count')
            ->orderBy('id')
            ->first();

        if ($responsible === null) {
            throw new DomainException('Nao existem usuarios elegiveis para atribuicao automatica.');
        }

        return $responsible;
    }
}

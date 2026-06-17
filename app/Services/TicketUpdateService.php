<?php

namespace App\Services;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;

class TicketUpdateService
{
    public function __construct(
        private readonly TicketAssignmentService $ticketAssignmentService,
    ) {
    }

    /**
     * Atualiza os campos editaveis do chamado e permite redistribuicao manual ou automatica.
     *
     * @param array<string, mixed> $data
     */
    public function update(Ticket $ticket, array $data): Ticket
    {
        $responsible = $this->resolveResponsible($data['responsible_id']);

        $ticket->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => TicketPriority::from($data['priority']),
            'status' => TicketStatus::from($data['status']),
            'responsible_id' => $responsible->id,
        ]);

        return $ticket->refresh();
    }

    private function resolveResponsible(string $responsibleId): User
    {
        if ($responsibleId === UpdateTicketRequest::AUTOMATIC_ASSIGNMENT) {
            return $this->ticketAssignmentService->assignAutomatically();
        }

        return User::query()->findOrFail((int) $responsibleId);
    }
}

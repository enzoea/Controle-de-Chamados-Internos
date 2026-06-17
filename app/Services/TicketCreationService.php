<?php

namespace App\Services;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\User;

class TicketCreationService
{
    public function __construct(
        private readonly TicketAssignmentService $ticketAssignmentService,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(User $requester, array $data): Ticket
    {
        $responsible = $this->resolveResponsible($data['responsible_id']);

        return Ticket::query()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => TicketPriority::from($data['priority']),
            'status' => TicketStatus::ABERTO,
            'requester_id' => $requester->id,
            'responsible_id' => $responsible->id,
            'opened_at' => now(),
        ]);
    }

    private function resolveResponsible(string $responsibleId): User
    {
        if ($responsibleId === StoreTicketRequest::AUTOMATIC_ASSIGNMENT) {
            return $this->ticketAssignmentService->assignAutomatically();
        }

        return User::query()->findOrFail((int) $responsibleId);
    }
}

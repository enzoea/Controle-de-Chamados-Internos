<?php

namespace Tests\Unit;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketAssignmentService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketAssignmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_selects_the_user_with_the_lowest_open_ticket_load(): void
    {
        $service = new TicketAssignmentService();

        $requester = User::factory()->create();
        $lessLoaded = User::factory()->create();
        $moreLoaded = User::factory()->create();

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $moreLoaded->id,
            'status' => TicketStatus::ABERTO,
            'priority' => TicketPriority::MEDIA,
        ]);

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $moreLoaded->id,
            'status' => TicketStatus::EM_ANDAMENTO,
            'priority' => TicketPriority::ALTA,
        ]);

        $responsible = $service->assignAutomatically();

        $this->assertTrue($responsible->is($requester));
    }

    public function test_ignores_completed_tickets_when_counting_open_load(): void
    {
        $service = new TicketAssignmentService();

        $requester = User::factory()->create();
        $withCompletedTicketsOnly = User::factory()->create();
        $withOneOpenTicket = User::factory()->create();

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $withCompletedTicketsOnly->id,
            'status' => TicketStatus::RESOLVIDO,
            'priority' => TicketPriority::MEDIA,
        ]);

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $withCompletedTicketsOnly->id,
            'status' => TicketStatus::FECHADO,
            'priority' => TicketPriority::BAIXA,
        ]);

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $withOneOpenTicket->id,
            'status' => TicketStatus::ABERTO,
            'priority' => TicketPriority::URGENTE,
        ]);

        $responsible = $service->assignAutomatically();

        $this->assertTrue($responsible->is($requester));
    }

    public function test_uses_the_lowest_id_as_tie_breaker(): void
    {
        $service = new TicketAssignmentService();

        $lowerId = User::factory()->create();
        $higherId = User::factory()->create();

        $responsible = $service->assignAutomatically();

        $this->assertTrue($responsible->is($lowerId));
        $this->assertTrue($lowerId->id < $higherId->id);
    }

    public function test_requester_can_also_be_selected_when_eligible(): void
    {
        $service = new TicketAssignmentService();

        $requester = User::factory()->create();
        $otherUser = User::factory()->create();

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $otherUser->id,
            'status' => TicketStatus::ABERTO,
            'priority' => TicketPriority::MEDIA,
        ]);

        $responsible = $service->assignAutomatically();

        $this->assertTrue($responsible->is($requester));
    }

    public function test_throws_a_business_error_when_there_are_no_eligible_users(): void
    {
        $service = new TicketAssignmentService();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Nao existem usuarios elegiveis para atribuicao automatica.');

        $service->assignAutomatically();
    }
}

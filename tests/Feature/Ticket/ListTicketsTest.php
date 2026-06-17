<?php

namespace Tests\Feature\Ticket;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTicketsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_list_requires_authentication(): void
    {
        $response = $this->get(route('tickets.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_ticket_list_ordered_by_most_recent_opening(): void
    {
        $user = User::factory()->create();

        $olderTicket = Ticket::factory()->create([
            'title' => 'Chamado antigo',
            'opened_at' => now()->subDay(),
        ]);

        $newerTicket = Ticket::factory()->create([
            'title' => 'Chamado recente',
            'opened_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('tickets.index'));

        $response->assertOk();
        $response->assertSeeInOrder([$newerTicket->title, $olderTicket->title]);
    }

    public function test_authenticated_users_can_filter_tickets_by_status_priority_and_responsible(): void
    {
        $user = User::factory()->create();
        $responsible = User::factory()->create(['name' => 'Responsavel filtrado']);
        $otherResponsible = User::factory()->create(['name' => 'Outro responsavel']);

        $matchingTicket = Ticket::factory()->create([
            'title' => 'Chamado filtrado',
            'priority' => TicketPriority::ALTA,
            'status' => TicketStatus::ABERTO,
            'responsible_id' => $responsible->id,
        ]);

        Ticket::factory()->create([
            'title' => 'Chamado fora do status',
            'priority' => TicketPriority::ALTA,
            'status' => TicketStatus::FECHADO,
            'responsible_id' => $responsible->id,
        ]);

        Ticket::factory()->create([
            'title' => 'Chamado fora da prioridade',
            'priority' => TicketPriority::BAIXA,
            'status' => TicketStatus::ABERTO,
            'responsible_id' => $responsible->id,
        ]);

        Ticket::factory()->create([
            'title' => 'Chamado fora do responsavel',
            'priority' => TicketPriority::ALTA,
            'status' => TicketStatus::ABERTO,
            'responsible_id' => $otherResponsible->id,
        ]);

        $response = $this->actingAs($user)->get(route('tickets.index', [
            'status' => TicketStatus::ABERTO->value,
            'priority' => TicketPriority::ALTA->value,
            'responsible_id' => $responsible->id,
        ]));

        $response->assertOk();
        $response->assertSee($matchingTicket->title);
        $response->assertDontSee('Chamado fora do status');
        $response->assertDontSee('Chamado fora da prioridade');
        $response->assertDontSee('Chamado fora do responsavel');
    }
}

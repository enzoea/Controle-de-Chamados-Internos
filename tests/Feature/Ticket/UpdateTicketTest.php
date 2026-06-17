<?php

namespace Tests\Feature\Ticket;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_ticket_screen_requires_authentication(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get(route('tickets.edit', $ticket));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_the_edit_ticket_screen(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.edit', $ticket));

        $response->assertOk();
        $response->assertSee('Editar chamado');
        $response->assertSee($ticket->title);
    }

    public function test_authenticated_users_can_update_a_ticket_with_manual_assignment(): void
    {
        $user = User::factory()->create();
        $newResponsible = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'requester_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'title' => 'Titulo atualizado',
            'description' => 'Descricao atualizada do chamado.',
            'priority' => TicketPriority::ALTA->value,
            'status' => TicketStatus::EM_ANDAMENTO->value,
            'responsible_id' => (string) $newResponsible->id,
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', 'Chamado atualizado com sucesso.');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Titulo atualizado',
            'description' => 'Descricao atualizada do chamado.',
            'priority' => TicketPriority::ALTA->value,
            'status' => TicketStatus::EM_ANDAMENTO->value,
            'requester_id' => $user->id,
            'responsible_id' => $newResponsible->id,
        ]);
    }

    public function test_authenticated_users_can_update_a_ticket_with_automatic_assignment(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'requester_id' => $user->id,
            'responsible_id' => $otherUser->id,
            'status' => TicketStatus::ABERTO,
        ]);

        Ticket::factory()->create([
            'requester_id' => $user->id,
            'responsible_id' => $otherUser->id,
            'status' => TicketStatus::EM_ANDAMENTO,
            'priority' => TicketPriority::MEDIA,
        ]);

        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'title' => 'Chamado redistribuido',
            'description' => 'Atualizacao com redistribuicao automatica.',
            'priority' => TicketPriority::URGENTE->value,
            'status' => TicketStatus::RESOLVIDO->value,
            'responsible_id' => 'automatic',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Chamado redistribuido',
            'status' => TicketStatus::RESOLVIDO->value,
            'responsible_id' => $user->id,
        ]);
    }

    public function test_ticket_update_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'requester_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->from(route('tickets.edit', $ticket))
            ->put(route('tickets.update', $ticket), [
                'title' => '',
                'description' => '',
                'priority' => '',
                'status' => '',
                'responsible_id' => '',
            ]);

        $response->assertRedirect(route('tickets.edit', $ticket));
        $response->assertSessionHasErrors([
            'title',
            'description',
            'priority',
            'status',
            'responsible_id',
        ]);
    }
}

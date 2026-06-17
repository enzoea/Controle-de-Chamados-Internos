<?php

namespace Tests\Feature\Ticket;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_ticket_screen_requires_authentication(): void
    {
        $response = $this->get(route('tickets.create'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_the_create_ticket_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tickets.create'));

        $response->assertOk();
        $response->assertSee('Abrir chamado');
    }

    public function test_authenticated_users_can_create_a_ticket_with_automatic_assignment(): void
    {
        $requester = User::factory()->create();
        $otherUser = User::factory()->create();

        Ticket::factory()->create([
            'requester_id' => $requester->id,
            'responsible_id' => $otherUser->id,
            'status' => TicketStatus::ABERTO,
            'priority' => TicketPriority::ALTA,
        ]);

        $response = $this->actingAs($requester)->post(route('tickets.store'), [
            'title' => 'Erro no acesso ao sistema',
            'description' => 'Nao consigo acessar o sistema interno.',
            'priority' => TicketPriority::URGENTE->value,
            'responsible_id' => 'automatic',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', 'Chamado aberto com sucesso.');

        $this->assertDatabaseHas('tickets', [
            'title' => 'Erro no acesso ao sistema',
            'description' => 'Nao consigo acessar o sistema interno.',
            'priority' => TicketPriority::URGENTE->value,
            'status' => TicketStatus::ABERTO->value,
            'requester_id' => $requester->id,
            'responsible_id' => $requester->id,
        ]);
    }

    public function test_authenticated_users_can_create_a_ticket_with_manual_assignment(): void
    {
        $requester = User::factory()->create();
        $responsible = User::factory()->create();

        $response = $this->actingAs($requester)->post(route('tickets.store'), [
            'title' => 'Impressora sem funcionar',
            'description' => 'A impressora do setor administrativo nao liga.',
            'priority' => TicketPriority::MEDIA->value,
            'responsible_id' => (string) $responsible->id,
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('tickets', [
            'title' => 'Impressora sem funcionar',
            'priority' => TicketPriority::MEDIA->value,
            'status' => TicketStatus::ABERTO->value,
            'requester_id' => $requester->id,
            'responsible_id' => $responsible->id,
        ]);
    }

    public function test_ticket_creation_validates_required_fields(): void
    {
        $requester = User::factory()->create();

        $response = $this->actingAs($requester)->from(route('tickets.create'))->post(route('tickets.store'), [
            'title' => '',
            'description' => '',
            'priority' => '',
            'responsible_id' => '',
        ]);

        $response->assertRedirect(route('tickets.create'));
        $response->assertSessionHasErrors([
            'title',
            'description',
            'priority',
            'responsible_id',
        ]);
    }
}

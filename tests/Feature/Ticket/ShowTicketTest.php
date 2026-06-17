<?php

namespace Tests\Feature\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_detail_requires_authentication(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get(route('tickets.show', $ticket));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_ticket_details(): void
    {
        $user = User::factory()->create();
        $requester = User::factory()->create([
            'name' => 'Solicitante Teste',
            'email' => 'solicitante@example.com',
        ]);
        $responsible = User::factory()->create([
            'name' => 'Responsavel Teste',
            'email' => 'responsavel@example.com',
        ]);

        $ticket = Ticket::factory()->create([
            'title' => 'Chamado detalhado',
            'description' => 'Descricao detalhada do chamado para visualizacao.',
            'requester_id' => $requester->id,
            'responsible_id' => $responsible->id,
        ]);

        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        $response->assertOk();
        $response->assertSee('Chamado detalhado');
        $response->assertSee('Descricao detalhada do chamado para visualizacao.');
        $response->assertSee('Solicitante Teste');
        $response->assertSee('Responsavel Teste');
        $response->assertSee('solicitante@example.com');
        $response->assertSee('responsavel@example.com');
    }
}

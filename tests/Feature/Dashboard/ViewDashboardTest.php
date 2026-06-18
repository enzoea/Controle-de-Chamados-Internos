<?php

namespace Tests\Feature\Dashboard;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_documented_dashboard_indicators(): void
    {
        $user = User::factory()->create();

        Ticket::factory()->count(2)->create([
            'status' => TicketStatus::ABERTO,
            'priority' => TicketPriority::MEDIA,
        ]);

        Ticket::factory()->create([
            'status' => TicketStatus::EM_ANDAMENTO,
            'priority' => TicketPriority::ALTA,
        ]);

        Ticket::factory()->count(3)->create([
            'status' => TicketStatus::RESOLVIDO,
            'priority' => TicketPriority::BAIXA,
        ]);

        Ticket::factory()->create([
            'status' => TicketStatus::FECHADO,
            'priority' => TicketPriority::URGENTE,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Total de chamados');
        $response->assertSee('Chamados abertos');
        $response->assertSee('Em andamento');
        $response->assertSee('Resolvidos');
        $response->assertSee('Fechados');
        $response->assertSeeInOrder([
            'Total de chamados',
            '7',
            'Chamados abertos',
            '2',
            'Em andamento',
            '1',
            'Resolvidos',
            '3',
            'Fechados',
            '1',
        ]);
    }
}

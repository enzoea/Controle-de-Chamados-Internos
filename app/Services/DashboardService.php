<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\Ticket;

class DashboardService
{
    /**
     * Retorna os indicadores gerenciais documentados para o dashboard.
     *
     * @return array<string, int>
     */
    public function getStats(): array
    {
        $groupedCounts = Ticket::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total' => (int) $groupedCounts->sum(),
            'abertos' => (int) ($groupedCounts[TicketStatus::ABERTO->value] ?? 0),
            'em_andamento' => (int) ($groupedCounts[TicketStatus::EM_ANDAMENTO->value] ?? 0),
            'resolvidos' => (int) ($groupedCounts[TicketStatus::RESOLVIDO->value] ?? 0),
            'fechados' => (int) ($groupedCounts[TicketStatus::FECHADO->value] ?? 0),
        ];
    }
}

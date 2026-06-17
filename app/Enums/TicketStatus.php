<?php

namespace App\Enums;

enum TicketStatus: string
{
    case ABERTO = 'ABERTO';
    case EM_ANDAMENTO = 'EM_ANDAMENTO';
    case RESOLVIDO = 'RESOLVIDO';
    case FECHADO = 'FECHADO';

    /**
     * Retorna os status considerados em aberto para distribuicao.
     *
     * @return list<string>
     */
    public static function openValues(): array
    {
        return [
            self::ABERTO->value,
            self::EM_ANDAMENTO->value,
        ];
    }
}

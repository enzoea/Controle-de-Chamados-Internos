<?php

namespace App\Http\Requests;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateTicketRequest extends FormRequest
{
    public const AUTOMATIC_ASSIGNMENT = 'automatic';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'status' => ['required', Rule::enum(TicketStatus::class)],
            'responsible_id' => ['required', 'string'],
        ];
    }

    /**
     * @return array<callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $responsibleId = (string) $this->input('responsible_id');

                if ($responsibleId === self::AUTOMATIC_ASSIGNMENT) {
                    return;
                }

                if (! ctype_digit($responsibleId)) {
                    $validator->errors()->add('responsible_id', 'Selecione uma atribuicao valida.');

                    return;
                }

                $responsibleExists = User::query()
                    ->whereKey((int) $responsibleId)
                    ->exists();

                if (! $responsibleExists) {
                    $validator->errors()->add('responsible_id', 'Selecione uma atribuicao valida.');
                }
            },
        ];
    }
}

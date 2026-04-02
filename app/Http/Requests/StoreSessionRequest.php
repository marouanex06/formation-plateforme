<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SessionMode;

class StoreSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['super-admin', 'admin']);
    }

    public function rules(): array
    {
        return [
            'formation_id' => ['required', 'exists:formations,id'],
            'user_id'      => ['required', 'exists:users,id'],
            'start_date'   => ['required', 'date', 'after:today'],
            'end_date'     => ['required', 'date', 'after:start_date'],
            'capacity'     => ['required', 'integer', 'min:1'],
            'mode'         => ['required', 'in:' . implode(',', array_column(SessionMode::cases(), 'value'))],
            'city'         => ['nullable', 'string', 'max:100'],
            'meeting_link' => ['nullable', 'url', 'required_if:mode,en_ligne', 'required_if:mode,hybride'],
            'status'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after'         => 'La date de début doit être dans le futur.',
            'end_date.after'           => 'La date de fin doit être après la date de début.',
            'meeting_link.required_if' => 'Le lien est obligatoire pour les sessions en ligne ou hybrides.',
        ];
    }
}
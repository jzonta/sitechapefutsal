<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'assunto' => ['nullable', 'string', 'max:120'],
            'mensagem' => ['required', 'string', 'max:5000'],
        ];
    }
}

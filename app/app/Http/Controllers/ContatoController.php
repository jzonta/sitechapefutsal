<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContatoRequest;
use App\Mail\ContatoMail;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function create()
    {
        return view('pages.contato');
    }

    public function store(ContatoRequest $request)
    {
        Mail::to(config('mail.contato_destino'))->send(new ContatoMail($request->validated()));

        return back()->with('sucesso', 'Mensagem enviada! Em breve entraremos em contato.');
    }
}

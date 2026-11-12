<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;

class ContatoMail extends Mailable
{
    public function __construct(public array $dados) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->dados['email'], $this->dados['nome'])],
            subject: 'Contato pelo site: '.($this->dados['assunto'] ?: 'sem assunto'),
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.contato');
    }
}

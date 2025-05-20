<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public string $tipoConsulta;
    public string $tipoTrabajo;
    public string $otroTrabajo;
    public string $nombre;
    public string $direccion;
    public string $telefono;
    public string $email;
    public string $mensaje;


    public function __construct($tipoConsulta, $tipoTrabajo, $otroTrabajo, $nombre, $direccion, $telefono, $email, $mensaje)
    {
        $this->tipoConsulta = $tipoConsulta;
        $this->tipoTrabajo = $tipoTrabajo;
        $this->otroTrabajo = $otroTrabajo;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Formulario de Contacto'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contacto',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

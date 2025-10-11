<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DenyReservationMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $Motivo;
    public $event;

   
    /**
     * Create a new message instance.
     */
    public function __construct(Event $event, $Motivo)
    {
        $this->event = $event;
        $this->Motivo = $Motivo;
    }    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope( 
          //  from: new Address('Correo@correo.com', "Nombre del propietario "),   // si no pones esto se toma el del .env 
            subject: 'Agenda CUAltos',  // Asunto del correo 
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.denyReservation',
            with: [
                'event' => $this->event,
                'Motivo' => $this->Motivo,
            ],
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

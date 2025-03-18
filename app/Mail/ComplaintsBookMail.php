<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintsBookMail extends Mailable
{
    use Queueable, SerializesModels;

    public $complaints;

    public function __construct($complaints)
    {
        $this->complaints = $complaints;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = config('app.name')." - Reclamo/Queja fue registrado";
        if(isset($this->complaints['ours']))$subject = config('app.name')." - Alguien hizo un reclamo/queja";
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('emails.e_complaints_book');
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

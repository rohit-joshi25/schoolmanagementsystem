<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SchoolMessageMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $messageSubject;
    public $messageBody;
    public $fromName;

    /**
     * Create a new message instance.
     */
    public function __construct($messageSubject, $messageBody, $fromName)
    {
        $this->messageSubject = $messageSubject;
        $this->messageBody = $messageBody;
        $this->fromName = $fromName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->messageSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // We will create this view file in the next step
        return new Content(
            markdown: 'emails.school-message',
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
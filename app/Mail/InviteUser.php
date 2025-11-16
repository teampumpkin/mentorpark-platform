<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $details;


    /**
     * Create a new message instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->details['subject'] ?? 'Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        /*return new Content(
            view: 'view.name',
        );*/
        return new Content(
            view: 'emails.invite-user', // path to Blade view
            with: [
                'subject' => $this->details['subject'] ?? 'Invitation',
                'name' => $this->details['name'] ?? 'Guest',
                'introText' => $this->details['introText'] ?? '',
                'messageText' => $this->details['message'] ?? '',
                'actionUrl' => $this->details['actionUrl'] ?? null,
                'actionText' => $this->details['actionText'] ?? 'Open Invitation',
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

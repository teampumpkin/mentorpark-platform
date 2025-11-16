<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MasterClassInvitationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $masterClass;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($masterClass, $user)
    {
        $this->masterClass = $masterClass;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation: ' . $this->masterClass->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $firstSession = $this->masterClass->sessions()->first();
        return new Content(
            view: 'emails.masterclass_invitation_notification',
            with: [
                'userName'     => $this->user->name,
                'classTitle'   => $this->masterClass->title,
                'bannerImage'  => $this->masterClass->banner_image
                    ? Storage::disk('master_class_banner_image')->url($this->masterClass->banner_image)
                    : null,
                'description'  => $this->masterClass->description,
                'startDateTime'=> optional($firstSession)->start_date_time
                    ? optional($firstSession->start_date_time)->format('d M Y, h:i A')
                    : null,
                'duration'     => $firstSession && $firstSession->start_date_time && $firstSession->end_date_time
                    ? $firstSession->start_date_time->diffInMinutes($firstSession->end_date_time) . ' mins'
                    : null,
                'trainerName'  => $this->user->name ?? 'Our Expert',
                'joinUrl'      => route('frontend.master-classes.show', $this->masterClass->slug),
                'unsubscribeUrl' => 'unsubscribe',
            ]
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

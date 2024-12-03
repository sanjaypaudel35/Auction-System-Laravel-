<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WinnerDeclaredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public bool $forProductOwner;

    public function __construct(array $mailData, bool $forProductOwner = false)
    {
        $this->mailData = $mailData;
        $this->forProductOwner = $forProductOwner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Auction/Bid Successfull',
            cc: $this->mailData["cc"] ?? null
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "emails.WinnerDeclaredMail",
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

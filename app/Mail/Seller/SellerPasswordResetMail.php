<?php

namespace App\Mail\Seller;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $seller;
    protected $actionLink;

    public function __construct($data)
    {
        $this->seller = $data['seller'];
        $this->actionLink = $data['actionLink'];
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Seller Password Reset Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email-templates.seller.seller-forgot-email-template',
            with: [
                'seller' => $this->seller,
                'actionLink' => $this->actionLink
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

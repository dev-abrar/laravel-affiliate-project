<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $userName;
    public $userEmail;

    /**
     * Create a new message instance.
     *
     * @param  string  $data
     * @param  string  $userName
     * @param  string  $userEmail
     */
    public function __construct($data, $userName, $userEmail)
    {
        $this->data = $data;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.message_mail', // Make sure the view is named correctly
            with: [
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
                'data' => $this->data, // Pass other data as well
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

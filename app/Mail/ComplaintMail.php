<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $complaint;
    public $supportingDocument;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $complaint, $supportingDocument)
    {
        $this->user = $user;
        $this->complaint = $complaint;
        $this->supportingDocument = $supportingDocument;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Complaint Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }

    // public function build()
    // {
    //     return $this->view('email.new_complaint')
    //         ->with([
    //             'user' => $this->user,
    //             'complaint' => $this->complaint,

    //         ]);
    // }
    public function build()
    {
        $email = $this->view('email.new_complaint')
            ->subject('Laporan Feedback Baru');
        if ($this->supportingDocument) {
            $email->attach($this->supportingDocument->getRealPath(), [
                'as' => 'DokumenPendukung.pdf',
                'mime' => 'application/pdf',
            ]);
        }
        return $email;
    }
}

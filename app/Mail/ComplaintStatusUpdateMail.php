<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Complaints;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $user;
    public $latestInteraction;


    /**
     * Create a new message instance.
     */
    public function __construct($user, Complaints $complaint, $latestInteraction)

    {
        $this->user = $user;
        $this->complaint = $complaint;
        $this->latestInteraction = $latestInteraction;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Complaint Status Update Mail',
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
    public function build()
    {
        return $this->subject('Pemberitahuan Perubahan Status Feedback')->view('email.status_complaint');
    }
}

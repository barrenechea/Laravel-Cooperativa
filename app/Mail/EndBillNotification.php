<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndBillNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $billdescriptions;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($billdescriptions)
    {
        $this->billdescriptions = $billdescriptions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Notificación de término de cobro' . (count($this->billdescriptions) > 1 ? 's' : '');
        return $this->subject($subject)->view('emails.endbillnotification');
    }
}
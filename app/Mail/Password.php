<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class Password extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $isNew;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password, $isNew)
    {
        $this->user = $user;
        $this->password = $password;
        $this->isNew = $isNew;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->isNew ? 'Su nueva cuenta en panel.alamedamaipu.cl' : 'Se han actualizado sus credenciales de acceso')->view('emails.password');
    }
}
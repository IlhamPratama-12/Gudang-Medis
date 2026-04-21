<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendAccountMail extends Mailable
{
    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Anda Disetujui')
            ->view('emails.account')
            ->with([
                'name'     => $this->user->name,
                'email'    => $this->user->email,
                'password' => $this->password,
            ]);
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $subject, string $txt)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->txt = $txt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail_name = $this->name;
        $mail_subject = $this->subject;
        $mail_txt = $this->txt;
        return $this->view('mail.body')->from('test@email.com')->subject($mail_subject)->with(['name' => $mail_name, 'txt' => $mail_txt]);
    }
}

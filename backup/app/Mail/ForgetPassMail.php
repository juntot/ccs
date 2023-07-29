<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPassMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $emailBody;
    public $uriLink;
    public function __construct($emailBody = '', $subject = '', $link = '')
    {
        //
        $this->subject = $subject ? $subject : 'noreply@homecareershire.com.au';
        $this->emailBody = $emailBody;
        $this->uriLink = $link ? $link: 'http://saas.42web.io/login';
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from('noreply@inventoryapps.com')
        //             ->subject($this->subject)
        //             ->view('mail.mailforgetpass');
        return $this->view('mail.mailforgetpass');
    }
}

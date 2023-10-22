<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillableMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $emailBody;
    public function __construct($emailBody = '', $subject = '', $link = '')
    {
        //
        $this->subject = $subject ? $subject : 'noreply@homecareershire.com.au';
        $this->emailBody = $emailBody;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        // ->from('junrey.gonzales.07@gmail.com')
                    ->subject($this->subject)
                    // ->view('mail.mailforgetpass');
        ->view('mail.billable');
    }
}

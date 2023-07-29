<?php

// namespace App\Repository;
namespace App\Services;

use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassMail;
use App\Services\UserSession;

class MailService{

    // header notifications
    public static function sendMail($recipient, $subject = '', $message = ''){

        $message = 'Your Approval is Requested by
                    <span style="color:#F97000">'.$result[0]->fullname.'</span>
                    <br><br>Regarding his/her
                    <span style="color:#F97000">'.$formType.'</span>';
        try {
            Mail::to($email)->send(new FormMail($message, $subject));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurlService;
use Carbon\Carbon;
use App\Services\UserSession;
use DB;

class QRAnnouncementController extends Controller
{
    //
    function postAnnouncement(){
        date_default_timezone_set("Asia/Hong_Kong");
        $uuid =  Carbon::now()->valueOf();
        $message = request('message');
        $userId = session()->get('auth.userId');
        
        DB::select("
            INSERT INTO announcement_logs (uuid, _userId, mobile, smsmessage, sentby)
            SELECT '$uuid', userId, guardian_contact, '$message', '$userId'
            FROM user_tbl
            WHERE (section IS NOT NULL and role = 0) or (role > 0 and role < 3)
            order by role desc
        ");
        
        return http_response_code(200);

        // view table database 
        // select userId, guardian_contact, section, role from user_tbl where userId not in(select log._userId from announcement_logs log inner join announcement ann on date(log.date_created) = ann.date_added);
    }   
}

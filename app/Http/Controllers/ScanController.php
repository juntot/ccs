<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Services\CurlService;
use Carbon\Carbon;

class ScanController extends Controller
{
    // MISRIUM REFLECT
    function __construct(){
        date_default_timezone_set("Asia/Hong_Kong");
    }

    // scan qr code
    function scanQr($userInfo = ''){
        // Carbon::setToStringFormat('jS \o\f F, Y g:i:s a');
        $finishTime = Carbon::now(); // Carbon::parse($this->finish_time);
        
       

        $status = 'in';
        // validation
        $record = DB::table('user_log')
        ->select('date_created', 'status')
        ->where('_userId', $userInfo)
        ->whereBetween('date_created', [date("Y-m-d").' 00:00:00', date("Y-m-d").' 23:59:59'])
        ->orderBy('date_created', 'desc')
        ->first();

        
        
        if($record){
            $status = $record->status == 'in' ? 'out': 'in';

            $startTime = Carbon::parse($record->date_created);
            $totalDuration = $finishTime->diffInSeconds($startTime);
            if($totalDuration / 60 < 10){
                return \Response::json(array(
                    'code'      =>  401,
                    'message'   => 'You are already logged'
                ), 401);
                // Please wait after 10 minutes.
            }
            else{
                $result = $this->qrRequest($userInfo, $status, $finishTime);
                if(!$result)
                return \Response::json(array(
                    'code'      =>  401,
                    'message'   => 'Record Not found'
                ), 401);

                return $result;
            }
            
        }
        else{
            $result = $this->qrRequest($userInfo, $status, $finishTime);
            if(!$result)
            return \Response::json(array(
                'code'      =>  401,
                'message'   => 'Record Not found'
            ), 401);
            return $result;
        }
        
    }

    function qrRequest($userInfo, $status, $finishTime){

        // try {
            $user = DB::table('user_tbl as user')
            ->join('section_tbl as section', 'user.section', '=', 'section.sectionId')
            ->select('user.userId','user.avatar', 'user.fullname', 'section.SectionName as section', 'user.guardian', 'user.guardian_contact', 'user.status')
            ->where('user.userId', $userInfo)
            ->first();

            if($user){

                request()->merge([
                    '_userId' => $userInfo,
                    'date_created' => $finishTime,
                    'sms' => 0,
                    'status' => $status,
                ]);

                DB::table('user_log')
                ->insert(request()->except('_token'));

                // request()->merge([
                //     '_userId' => $userInfo,
                //     'date_created' => $finishTime,
                //     'sms' => 0,
                //     'status' => $status,
                // ]);
    
                // $db = DB::table('user_log')
                //         ->insert(request()->except('_token'));

                // call SMS
                // $timelog = $finishTime->format('l jS \\of F Y h:i A'); 

                // $message = "Good Day Sir/Ma'am, \n".
                // "your Son/Daughter ".$user->fullname.
                // " exited the school around ".$timelog.
                // "\n\nCordova Catholic Cooperative School. ❤️CCCS_cares";

                // if($status == 'in')
                // {
                //     $message = "Good Day Sir/Ma'am, \n".
                //     "your Son/Daughter ".$user->fullname.
                //     " entered the school around ".$timelog.
                //     "\n\nCordova Catholic Cooperative School. 
                //     ❤️CCCS_cares";
                // }

                // $sms = new CurlService();
                // $result = $sms->sendSMS($user->guardian_contact, $message, 5);
                
                // if($result != 'failed'){
                //     sleep(1);
                //     $sms->sendSMS($user->guardian_contact, $message, 5);
                // }
                

                // set date inserted
                $user->date_created = $finishTime;
                $user->status = $status;
                return $user;
            }
            else{
                return false;
            }
    }
}

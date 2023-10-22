<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Services\CurlService;
use Carbon\Carbon;

class GSMController extends Controller
{
    //
    function sendSMS(){
        $attempt = 0;
        $user = DB::table('user_log as log')
                ->join('user_tbl as user', 'log._userId', '=', 'user.userId')
                ->select('log.*', 'user.fullname', 'user.guardian', 'user.guardian_contact')
                ->whereRaw('LENGTH(`user`.`guardian_contact`) = 11')
                ->where('badnum', 0)
                ->where('sms', 0)
                ->orderBy('date_created')
                ->first();
                // ->toSql();

        // return $user;
        if(!$user)
        return http_response_code(200);

        if($user->guardian_contact == NULL || $user->guardian_contact == '')
        return http_response_code(200);

        $datecarbon = Carbon::parse($user->date_created);
        $mobilenum = trim($user->guardian_contact);
        // $mobilenum = trim('09452187701');

        $message = "Good Day Sir/Ma'am, \n Your Son/Daughter ";
        $message .= $user->fullname;

        if($user->status == 'in'){
            $message .= ' entered the school around ';

        }else{
            $message .= ' exited the school around';

        }
        $message .= $datecarbon->toDayDateTimeString();
        // return $message;
        
        // include App Name
        $message .= " \n \n \n ".env('APP_NAME', 'Amira')." \n";
        $message .= "❤️CCCS_cares";
        $response = $this->smsRequest($mobilenum, $message, 5);
        
        // return $response;
        if($response == 'failed'){
            while ($response == 'failed' && $attempt <= 3) {
                $response = $this->smsRequest($mobilenum, $message, 5);
                $attempt ++;
            }

            if($attempt >= 3){
                DB::table('user_log')
                ->where('_userId', $user->_userId)
                ->update(['badnum' => 1]);
            }
        }else{
            DB::table('user_log')
                ->where('_userId', $user->_userId)
                ->update(['sms' => 1]);
        }
        
        // return $response;
        return http_response_code(200);
    }

    function smsRequest($number, $message, $port){
        $curl = new CurlService;
        return $curl->sendSMS($number, $message, $port);
    }



    // send every minute
    function batchSend(){
        $runningBatch = false;

        $runningBatch = DB::table('service_tbl')->select('batch')->first();
        if($runningBatch->batch == 1){
            return true;
        }else{
            DB::table('service_tbl')
            ->update(['batch' => 1]);

            $users = DB::select('select user.guardian_contact, user.fullname, log.date_created, log._userId, log.status
                    from user_tbl user inner join user_log log
                    on user.userId = log._userId
                    where log.sms = 0');


            if($users){
                // call SMS
                foreach ($users as $value) {
                    
                    $message = "Good Day Sir/Ma'am, \n".
                    "your Son/Daughter ".$value->fullname.
                    " exited the school around ".$value->date_created.
                    "\n\nCordova Catholic Cooperative School. ❤️CCCS_cares";

                    if($value->status == 'in')
                    {
                        $message = "Good Day Sir/Ma'am, \n".
                        "your Son/Daughter ".$value->fullname.
                        " entered the school around ".$value->date_created.
                        "\n\nCordova Catholic Cooperative School. 
                        ❤️CCCS_cares";
                    }

                    $sms = new CurlService();
                    $result = $sms->sendSMS($value->guardian_contact, $message, 5);
                    $result = $sms->sendSMS($value->guardian_contact, $message, 5);
                    
                    if($result != 'failed'){
                        sleep(1);
                        $sms->sendSMS($value->guardian_contact, $message, 5);
                        if($result != 'failed'){
                            DB::table('user_log')
                            ->where('_userId', $value->_userId)
                            ->update(['sms' => 2]);   
                        }
                        else{
                            DB::table('user_log')
                            ->where('_userId', $value->_userId)
                            ->update(['sms' => 1]);
                        }
                    }else{
                        DB::table('user_log')
                        ->where('_userId', $value->_userId)
                        ->update(['sms' => 1]);   
                    }
                    sleep(10);
                }
                
            }else{
                DB::table('service_tbl')
                            ->update(['batch' => 0]);
            }
        }
            
    }

    // manual retry send sms
    function manualRetrySms(){
        
        $data =  DB::table('user_log')
                ->where('_userId', request('_userId'))
                ->where('date_created', request('date_created'))
                ->update(['sms' => 0]);
        return $data;
    }

    // live send SMS
    function sendLiveSMS($smsport = '', $start = '', $limit = ''){
            if(!$smsport)
            {
                echo 'sms failed no sms port selected';
                return;
            }
            $result = DB::select("Select user.guardian_contact, user.fullname, log.date_created, log._userId, log.status
                                  from user_tbl user inner join user_log log
                                  on user.userId = log._userId
                                  where log.sms = 0 order by log.date_created limit ".$start.", ".$limit); 
            
            
            echo 'sms sending: ';
            $mobilenum_pattern = "/^(09)\d{9}$/";
            if($result){
                foreach ($result as $value) {
                    
                  if(!preg_match($mobilenum_pattern, $value->guardian_contact))
                  {
                    $sms = 2;
                    $this->updateSMSlog($value->_userId, $value->date_created, $sms );
                    continue;
                  }
                  
                  $status = $value->status;
                  $msg = $this->smsMessageTemplate($value->status, $value->fullname, $value->date_created);
                  $smsResult = $this->smsRequest($value->guardian_contact, $msg, $smsport);
                  $sms = 1;
                  echo ' -'.$smsResult.'- ';
                //   $smsResult = 'success';
                //   dd($value->guardian_contact, $msg);
                  if($smsResult == 'failed'){
                    sleep(1);
                    
                    $count = 1;
                    while ($smsResult == 'failed' && $count <= 2) {
                      $smsResult = $this->smsRequest($value->guardian_contact, $msg, $smsport);
                      $count++;
                    }

                    if($smsResult == 'failed')
                    $sms = 2;
        
                    $this->updateSMSlog($value->_userId, $value->date_created, $sms );
          
                  }else{
                    $this->updateSMSlog($value->_userId, $value->date_created, $sms );
                  }
                  sleep(10);
                }
            }
        // $this->smsRequest($number, $message, $port);
    }

    function smsMessageTemplate($status, $fullname, $timelog){
        $message = "Good Day Sir/Ma'am, \n".
                      "your Son/Daughter ".$fullname.
                      " exited the school around ".date('m/d/Y h:i a', strtotime($timelog)).
                      "\n\nCordova Catholic Cooperative School. ❤️CCCS_cares";
      
        if($status == 'in')
        {
            $message = "Good Day Sir/Ma'am, \n".
            "your Son/Daughter ".$fullname.
            " entered the school around ".date('m/d/Y h:i a', strtotime($timelog)).
            "\n\nCordova Catholic Cooperative School. 
            ❤️CCCS_cares";
        }
      
        return $message."\nThis message is automated. Do Not Reply";
    }

    function updateSMSlog($id, $datelog, $sms){
        DB::table('user_log')
            ->where('_userId', $id)
            ->where('date_created', $datelog)
            ->update(['sms' => $sms]);
        
      }



    //  live SEND SMS ANNOUNCEMENT
    function updateAnnouncementLogStatus($uuid, $userId, $status, $port){
        date_default_timezone_set("Asia/Hong_Kong");
        $dateNow = date("Y-m-d H:i:s");

        DB::table('announcement_logs')
            ->where('uuid', $uuid)
            ->where('_userId', $userId)
            ->update([
                'date_sent' => $dateNow,
                'port'      => $port,
                'status'    => $status,
            ]);
      }

      function sendLiveSMSAnnouncement($smsport = '', $start = '', $limit = ''){

        if(!$smsport)
        {
            echo 'sms failed no sms port selected';
            return;
        }
        
        try {
        
                $stmt = DB::select("Select * from announcement_logs where status = 0 limit ".$start.", ".$limit); 
                $mobilenum_pattern = "/^(09)\d{9}$/";
                echo 'sms sending:: ';
                if($result){
                    foreach ($result as $value) {
                    
                    if(!preg_match($mobilenum_pattern, $value->mobile))
                    {
                        $sms = 2;
                        $this->updateAnnouncementLogStatus($value->uuid, $value->_userId, $sms, $smsport);
                        continue;
                    }
                    
                    $message_ann = $value->smsmessage."\n\nCordova Catholic Cooperative School. 
                    ❤️CCCS_cares";
                    $smsResult = $this->smsRequest($value->mobile, $message_ann, $smsport);
                    $sms = 1;
                    echo ' -'.$smsResult.'- ';
                    
                    if($smsResult == 'failed'){
                        sleep(1);
                        $count = 1;
                        while ($smsResult == 'failed' && $count <= 2) {
                        $smsResult = $this->smsRequest($value->mobile, $message_ann, $smsport);
                        $count++;
                        }
                        
                        if($smsResult == 'failed')
                        $sms = 2;
                        $this->updateAnnouncementLogStatus($value->uuid, $value->_userId, $sms, $smsport);
        
                    }else{
                        $this->updateAnnouncementLogStatus($value->uuid, $value->_userId, $sms, $smsport);
                    }
                    sleep(8);
                    }
                }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

      }

      
      
      
}


<?php

namespace App\Services;
use \PDO;
require_once('DBServe.php');



// CURL class
class CurlService{

  private $host = '';
  private $port = '';
  private $username = ''; 
  private $password = '';

  public function __construct() {
        $this->host     = 'http://sap4.northtrend.com';
        $this->port     = '80';
        $this->username = 'apiuser';
        $this->password = 'apipass';
  } 
  
  public function sendSMS($mobile, $message = '',$channel){
    $debug = 'on';
    $smskey = '12345';
    $SMS_gateway_account = 'apiuser';
    $SMS_gateway_password = 'apipass';
    $SMS_leader = 'Use ';
    $SMS_trailer = ' for SMS validation';
    $SMS_message = $message;
    // $channel = '5';
    $SMS_gateway = 'sap4.northtrend.com';
    $SMS_port = '80';
    $SMS_destination = $mobile;
    // Starting Assumptions
    $SMS_success = 'NO';

    $ch = curl_init();
    $SMS_gateway_password_encoded = curl_escape($ch, $SMS_gateway_password);
    $SMS_message_encoded = curl_escape($ch, $SMS_message);
    $transmission = "http://" . $SMS_gateway . ":" . $SMS_port . "/cgi/WebCGI?1500101=account=" . $SMS_gateway_account . "&password=" . $SMS_gateway_password_encoded . "&port=" . $channel . "&destination=" . $SMS_destination . "&content=" . $SMS_message_encoded;
    curl_setopt($ch, CURLOPT_URL, $transmission);

    // if ($debug == 'on') { echo '<hr>' . $transmission . '<hr>'; }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $SMS_result = curl_exec($ch);

    if ($debug == 'on') { echo 'result- '.$SMS_result . '<hr>'; }

    if ((strpos($SMS_result, 'Response: Success') !== false) && ((strpos($SMS_result, 'Message: Commit successfully!') !== false)))
    {
      echo '-- true --';
      $SMS_success = 'YES';
    }
    else
    {
      echo '-- false --';
      $SMS_success = 'NO';
    }
    curl_close($ch);
    $SMS_success = 'YES';

        if ($SMS_success == 'YES')
        {
          return 'success';
        }
        else
        {
          return 'failed';
        }
  }
}





function sendMsg($number, $message, $port){
  $curl = new CurlService;
  return $curl->sendSMS($number, $message, $port);

}


function updateSMSlog($con, $id, $datelog, $sms){
  $sql = "UPDATE user_log SET sms = '$sms' WHERE _userId = '$id' and date_created='$datelog'";
  // Prepare statement
  $stmt = $con->prepare($sql);
  // execute the query
  $stmt->execute();
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

try {
  $stmt = $conn->query("Select user.guardian_contact, user.fullname, log.date_created, log._userId, log.status
                        from user_tbl user inner join user_log log
                        on user.userId = log._userId
                        where log.sms = 0 order by log.date_created limit 5"); 
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo 'sms sending: ';
  $mobilenum_pattern = "/^(09)\d{9}$/";
  if($result){
      foreach ($result as $value) {
        
        if(!preg_match($mobilenum_pattern, $value['guardian_contact']))
        {
          $sms = 2;
          updateSMSlog($conn, $value['_userId'], $value['date_created'], $sms );
          continue;
        }


        $status = $value['status'];
        $msg = smsMessageTemplate($value['status'], $value['fullname'], $value['date_created']);
        $smsResult = sendMsg($value['guardian_contact'], $msg, 3);
        $sms = 1;
        $smsResult = 'success';
        
        if($smsResult == 'failed'){
          sleep(1);
          // $smsResult = sendMsg($value['guardian_contact'], $value['date_created'], $msg, 5);
          $count = 1;
          while ($smsResult == 'failed' && $count <= 3) {
            $smsResult = sendMsg($value['guardian_contact'], $msg, 3);
            $count++;
          }
          // if($smsResult == 'failed')
          // $result = sendMsg($value['guardian_contact'], $value['date_created'], $msg, 5);

          if($smsResult == 'failed')
          $sms = 2;
          updateSMSlog($conn, $value['_userId'], $value['date_created'], $sms );

        }else{
          updateSMSlog($conn, $value['_userId'], $value['date_created'], $sms );
        }
        sleep(10);
      }
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}




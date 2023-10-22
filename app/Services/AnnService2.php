<?php
namespace App\Services;
use \PDO;
require_once('DBServe.php');
require_once('SMSCurlService.php');


function sendMsg($number, $message, $port){
  return sendSMS($number, $message, $port);

}

function updateAnnouncementLogStatus($con, $uuid, $userId, $status, $port){
  date_default_timezone_set("Asia/Hong_Kong");
  $dateNow = date("Y-m-d H:i:s");
  $sql = "UPDATE announcement_logs SET date_sent = '$dateNow', port='$port', status = '$status' where uuid = '$uuid' and _userId = '$userId'";
  // Prepare statement
  $stmt = $con->prepare($sql);
  // execute the query
  $stmt->execute();
}

$smsport = 7;
try {

      $stmt = $conn->query("Select * from announcement_logs where status = 0 limit 5,5"); 
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $mobilenum_pattern = "/^(09)\d{9}$/";
      echo 'sms sending:: ';
      if($result){
          foreach ($result as $value) {
            
            if(!preg_match($mobilenum_pattern, $value['mobile']))
            {
              $sms = 2;
              updateAnnouncementLogStatus($conn, $value['uuid'], $value['_userId'], $sms, $smsport);
              continue;
            }
            
            $smsResult = sendMsg($value['mobile'], $value['smsmessage'], $smsport);
            $sms = 1;
            $smsResult = 'success';
            
            if($smsResult == 'failed'){
              sleep(1);
              $count = 1;
              while ($smsResult == 'failed' && $count <= 3) {
                $smsResult = sendMsg($value['mobile'], $value['smsmessage'], $smsport);
                $count++;
              }
              
              if($smsResult == 'failed')
              $sms = 2;
              updateAnnouncementLogStatus($conn, $value['uuid'], $value['_userId'], $sms, $smsport);

            }else{
              updateAnnouncementLogStatus($conn, $value['uuid'], $value['_userId'], $sms, $smsport);
            }
            sleep(8);
          }
      }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

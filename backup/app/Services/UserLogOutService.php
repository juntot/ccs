<?php

namespace App\Services;
use \PDO;
require_once('DBServe.php');

function insert($con, $id, $status, $sms){
  $sql = "UPDATE user_log SET status='$status', sms = '$sms' WHERE _userId = '$id'";
  // Prepare statement
  $stmt = $con->prepare($sql);
  // execute the query
  $stmt->execute();
}
try {
  
        $dateNow = date("Y-m-d");
        $sql = "INSERT INTO user_log (_userId, date_created, status, sms, badnum)
                Select _userId, DATE_FORMAT(DATE_ADD(date_created, INTERVAL 1 SECOND), '%Y-%m-%d 00:%i:%S'), 
                'out', 2, 1 from user_log where DATE(date_created) = :datenow group by _userId having count(_userId) MOD 2 > 0
        ";
        echo $sql;
        $conn->prepare($sql)->execute(['datenow' => $dateNow]);
        
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

// select `_userId`,`date_created` from `user_log` group by `_userId` having count(`_userId`) MOD 2 > 0


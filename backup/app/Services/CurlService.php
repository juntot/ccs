<?php

namespace App\Services;

class CurlService{

  private $host = '';
  private $port = '';
  private $username = ''; 
  private $password = '';

  public function __construct() {
        $this->host     = env('SMS_HOST', 'http://sap4.northtrend.com');
        $this->port     = env('SMS_PORT', '80');
        $this->username = env('SMS_USER', 'apiuser');
        $this->password = env('SMS_PASS', 'apipass');
  } 
  
  public function sendSMS($mobile, $message = '',$channel){
    $debug = 'on';
    $SMS_gateway_account = $this->username;
    $SMS_gateway_password = $this->password;


    $smskey = '12345';
    $SMS_leader = 'Use ';
    $SMS_trailer = ' for SMS validation';

    // $SMS_message = $SMS_leader . $smskey . $SMS_trailer;
    $SMS_message = $message;

    // $SMS_channel_count = '4';
    // $channel = 4;
    $SMS_gateway = $this->host;
    $SMS_port = $this->port;
    $SMS_destination = $mobile;

    // $SMS_destination = 61 . substr($mobile, -9);
    // Starting Assumptions
    $SMS_success = 'NO';

    // Produce an array with unique random SMS ports in the channel count range starting at 1
    // $random_port_array = range(1, $SMS_channel_count);
    
    // shuffle($random_port_array);
    // foreach($random_port_array as $channel)
    // {
    
        $ch = curl_init();
        $SMS_gateway_password_encoded = curl_escape($ch, $SMS_gateway_password);
        $SMS_message_encoded = curl_escape($ch, $SMS_message);
        $transmission = $SMS_gateway . ":" . $SMS_port . "/cgi/WebCGI?1500101=account=" . $SMS_gateway_account . "&password=" . $SMS_gateway_password_encoded . "&port=" . $channel . "&destination=" . $SMS_destination . "&content=" . $SMS_message_encoded;
        
        curl_setopt($ch, CURLOPT_URL, $transmission);
        
        if ($debug == 'on') { 
          // echo '<hr>' . $transmission . '<hr>'; 
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $SMS_result = curl_exec($ch);
        
        if ($debug == 'on') { 
          // echo $SMS_result . '<hr>';
          // return $SMS_result;
        }
        
        if ((strpos($SMS_result, 'Response: Success') !== false) && ((strpos($SMS_result, 'Message: Commit successfully!') !== false)))
        {
          $SMS_success = 'YES';
        }
        else
        {
          $SMS_success = 'NO';
        }

        curl_close($ch);

        if ($SMS_success == 'YES')
        {
          // echo '<h1 align="center">SMS SENT</h1>';
          return 'success';
        }
        else
        {
          // echo '<h1 align="center">SMS FAIL</h1>';
          return 'failed';
        }
    // }
  }
}
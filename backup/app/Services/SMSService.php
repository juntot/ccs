<?php

namespace App\Services;
echo 'asdf';
class SMSService{

  private $host = '';
  private $port = '';
  private $username = ''; 
  private $password = '';
  private $channel = '';

  public function __construct() {
      
        $this->host     = env('SMS_HOST', 'http://sap4.northtrend.com');
        $this->port     = env('SMS_PORT', '80');
        $this->username = env('SMS_USER', 'apiuser');
        $this->password = env('SMS_PASS', 'apipass');
        $this->channel  = env('SMS_CHANNEL', 7);
  } 
  
  public function sendSMS($mobile, $message = '', $channel = 7){
    $debug = 'on';
    $this->channel  = env('SMS_CHANNEL', $channel);

    $SMS_gateway = $this->host;
    $SMS_port = $this->port;
    $this->curlSMS($mobile, $message);
  }

  public function curlSMS($mobile, $SMS_message){
    $debug = 'on';
    $SMS_success = 'NO';
    $ch = curl_init();
    $SMS_gateway_password_encoded = curl_escape($ch, $this->password);
    $SMS_message_encoded = curl_escape($ch, $SMS_message);
    $transmission = $this->host . ":" . $this->port . "/cgi/WebCGI?1500101=account=" . $this->username . "&password=" . $SMS_gateway_password_encoded . "&port=" . $this->channel . "&destination=" . $mobile . "&content=" . $SMS_message_encoded;
    
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
      return 'true';
    }
    else
    {
      // echo '<h1 align="center">SMS FAIL</h1>';
      return 'false';
    }
  }
}
<?php
namespace App\Services\Curl;

class SMSService{

  private $host = '';
  private $port = '';
  private $username = ''; 
  private $password = '';
  private $channel = '';

  public function __construct(){
    $this->host     = env('SMS_HOST_SERVICE', 'http://sap4.northtrend.com');
    $this->port     = env('SMS_PORT', '777');
    $this->username = env('SMS_USER', 'apiuser');
    $this->password = env('SMS_PASS', 'apipass');
    $this->channel  = env('SMS_CHANNEL', 7);
  }
}
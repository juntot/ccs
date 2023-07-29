<?php
// namespace App\Services;
echo 'asdf </br>';
function httpCurlRequest($url, $method = 'GET', $postfields = [], $headers = ''){
        // phpinfo();

            $ch = curl_init();
            // $url = curl_escape($ch, $url);
            // curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 30,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_HTTPHEADER => array(
            //     "Cache-Control: no-cache"
            // ),
        ));
            

    
            $result = curl_exec($ch);
            

            // var_dump($http_response_header);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            
            
            $err = curl_error($ch);
            curl_close($ch);
            // echo strpos($result, 'Response: Error') != true;
            
            // return;
            if( (strpos($result, 'Response: Error')) != true  || ((strpos($SMS_result, 'Response: Success') !== false) && ((strpos($SMS_result, 'Message: Commit successfully!') !== false))) )
            return $result;
            
            return 'Response: Error -- '. $result;
            if ($err) {
                return $err;
            } else {
                return true;
                // return ['data'=> json_decode($result), 'status'=>$httpcode];
            }
            
            // curl_get_file_contents($url);
            
    }

echo httpCurlRequest('http://sap4.northtrend.com:777/cgi/WebCGI?1500101=account=apiuser&password=apipass&port=5&destination=09151379201&content=Hellos');

return;

    $debug = 'on';
    $smskey = '12345';
    // $mobile = '041234567';
    $SMS_gateway_account = 'apiuser';
    $SMS_gateway_password = 'apipass';
    
    $SMS_leader = 'Use ';
    $SMS_trailer = ' for SMS validation';
    $SMS_message = $SMS_leader . $smskey . $SMS_trailer;
    
    // $SMS_channel_count = '4';
    $SMS_gateway = 'http://sap4.northtrend.com';
    $SMS_port = '777';
    $SMS_destination = '0915137921';
    // Starting Assumptions
    $SMS_success = 'NO';
    // Produce an array with unique random SMS ports in the channel count range starting at 1
    // $random_port_array = range(1, $SMS_channel_count);
    $channel = 7;
    
    
        $ch = curl_init();
        $SMS_gateway_password_encoded = curl_escape($ch, $SMS_gateway_password);
        $SMS_message_encoded = curl_escape($ch, $SMS_message);
        $transmission = $SMS_gateway . ":" . $SMS_port . "/cgi/WebCGI?1500101=account=" . $SMS_gateway_account . "&password=" . $SMS_gateway_password_encoded . "&port=" . $channel . "&destination=" . $SMS_destination . "&content=" . $SMS_message_encoded;
        curl_setopt($ch, CURLOPT_URL, $transmission);
        if ($debug == 'on') { echo '<hr>' . $transmission . '<hr>'; }
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        
        $SMS_result = curl_exec($ch);
        echo 'result: '.$SMS_result;
        if ($debug == 'on') { echo $SMS_result . '<hr>'; }
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
        echo '<h1 align="center">SMS SENT</h1>';
        // break;
        }
        else
        {
        echo '<h1 align="center">SMS FAIL</h1>';
        }
    

// }

// $sms = new SMSCurlService();

// $sms->curlSMS('09151379201', 'this is a test..');
// $sms->curlSMS('09452187701', 'this is a test bobby berdz');

?>


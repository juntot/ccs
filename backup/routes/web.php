<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
function sendSMS($mobile, $message = '',$channel){
    $debug = 'on';
    $SMS_success = 'NO';
    $ch = curl_init();
    $SMS_gateway_password_encoded = curl_escape($ch, "apipass");
    $SMS_message_encoded = curl_escape($ch, $message);
    $transmission = "http://sap4.northtrend.com" . ":" . "777" . "/cgi/WebCGI?1500101=account=" . "apiuser" . "&password=" . $SMS_gateway_password_encoded . "&port=" . $channel . "&destination=" . $mobile . "&content=" . $SMS_message_encoded;
    
    curl_setopt($ch, CURLOPT_URL, $transmission);
    
    if ($debug == 'on') { 
      echo '<hr>' . $transmission . '<hr>'; 
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $SMS_result = curl_exec($ch);
    echo $SMS_result;
    if ($debug == 'on') { 
      echo $SMS_result . '<hr>';
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
      echo '<h1 align="center">SMS SENT</h1>';
      return true;
    }
    else
    {
      echo '<h1 align="center">SMS FAIL</h1>';
      return false;
    }
}



Route::get('/api/mail', function(){
    $email = 'email@email.com';
    Mail::to($email)->send(new \App\Mail\ForgetPassMail('body', 'subject'));
    return 'awsss';
});
Route::get('/sms/test/{num?}/{port?}', function($num='09151379201', $port = 7){
    return sendSMS($num, 'message', $port);
    
});


Route::get('/test', function(){return view('scanner-backup');});

// Route::group(['middleware' => 'prevent-back-history'], function(){


Route::post('/authlogin', 'AuthUserController@login');

Route::get('/login', 'AuthUserController@loginView')->name('login');

Route::get('/ystartg8001', 'GSMController@sendSMS');



// sms
Route::get('/testlogs', 'GSMController@batchSend');

Route::group(['middleware' => 'authuser'], function () {

    // announcement
    Route::post('/announcement', 'QRAnnouncementController@postAnnouncement');

    // home
    Route::get('/', function(){ return view('home');})->name('home');
    
    // users
    Route::get('/users', 'AuthUserController@getUsers')->name('users');

    Route::post('/new-user', 'AuthUserController@addUser');
    Route::post('/update-user', 'AuthUserController@updateUser');
    Route::post('/rem-user', 'AuthUserController@removeUser');
    Route::post('/change-pass', 'AuthUserController@changePass');
    Route::post('/change-pass-userdefine', 'AuthUserController@changePassUserDefine');
    Route::get('/authlogout', 'AuthUserController@logout');
    
    Route::post('/reset-users', 'AuthUserController@resetUsers');

    // user - uncategorize
    Route::get('/uncategorize-users', 'AuthUserController@getUncategorizeUsers');
    
    // scanner
    Route::get('/scan', function(){ return view('scanner-device'); })->name('scan');
    Route::get('/scan-qr/{userId?}', 'ScanController@scanQr');    
    Route::get('/scan-device/{userId?}', 'ScanController@scanQr');    

    // SMS
    Route::post('/retry-sms', 'GSMController@manualRetrySms');

    // settings
    Route::get('/settings', function(){ return view('settings');})->name('settings');

    // Sections
    Route::get('/sections', 'QRSectionController@viewSection')->name('sections');
    Route::post('/new-section', 'QRSectionController@createSection');
    Route::post('/update-section', 'QRSectionController@updateSection');
    Route::post('/rem-section', 'QRSectionController@delSection');

    // report
    Route::get('/report', function(){return view('report');})->name('report');
    Route::post('/report-info', 'LogController@getLogs');
    
    // settings
    Route::post('/cover-page', 'SettingController@coverPage');

});

// });
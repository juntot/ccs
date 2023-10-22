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



Route::get('/test', function(){return view('scanner-backup');});

// Route::group(['middleware' => 'prevent-back-history'], function(){

// MAIL ===========================================================

Route::get('/api/mail', function(){
  // return view('mail.billable');
  $email = 'junreygonzales07@gmail.com';
  try {
    Mail::to($email)->send(new \App\Mail\BillableMail('io', 'Invoice'));
  } 
  catch (Swift_TransportException $e) {
      echo $e->getMessage();
  }
  
  
});


// SMS ============================================================
Route::get('/testlogs', 'GSMController@batchSend');
Route::get('/api/gsm-live/{port?}/{start?}/{limit?}', 'GSMController@sendLiveSMS');
Route::get('/api/gsm-live-announcement/{port?}/{start?}/{limit?}', 'GSMController@sendLiveSMSAnnouncement');


// MAIN APP ======================================================
Route::post('/authlogin', 'AuthUserController@login');

Route::get('/login', 'AuthUserController@loginView')->name('login');

Route::get('/ystartg8001', 'GSMController@sendSMS');

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
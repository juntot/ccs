<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hash;
use DB;
use Carbon\Carbon;
use App\Services\UserSession;
// use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthUserController extends Controller
{
    function __construct(){
        date_default_timezone_set("Asia/Hong_Kong");
    }

    function addUser(){
        $created_at = Carbon::now();
        // QrCode::backgroundColor(4, 114, 24);
        $qr = QrCode::size(100)
                ->eyeColor(0, 4, 114, 24, 0 ,0 ,0)
                ->eyeColor(1, 4, 114, 24, 0 ,0 ,0)
                ->eyeColor(2, 4, 114, 24, 0 ,0 ,0)
                ->generate("request('userId')");
        return $qr;
        
    }

    // login
    function login(){
        
        session([
            'auth.userId'    => '$user->email', 
            'auth.role'     => 1, 
           ]);
        return redirect()->route('home');

        // $user = DB::select('select * from user_tbl  where (email = :email) and status = 1', [request('email')]);
        
        $user = DB::table('user_tbl')->where('userId', request('userId'))->first();
        if($user && Hash::check(request('password'), ($user->password)))
        {
            session([
                     'auth.userId'    => $user->userId, 
                     'auth.type'     => 0, 
                     'auth.fullname' => $user->fullName,
                     'auth.mobile'   => $user->mobile,
                     'auth.avatar'   => $user->avatar,
                     'auth.state'    => $user->state,
                     'auth.suburb'   => $user->suburb
                    ]);
            return redirect()->route('home');
        }


        request()->flash();
        return redirect()->back()->withErrors([
            'message'=> 'Invalid email or password',
            // 'email'=> 'email not found'
        ]);
    }

    // login view
    function loginView(){
        if(session()->get('auth.empID')){
            return redirect('/');
        }else{
            return view('/login');
        }
    }

    // reset password
    function resetPass(){
        session()->flush();
        return redirect()->route('login');
    }


    // forgetpass
    function forgetPassView(){
        
        return view('forgetpass');
    }
    
    function forgetPass(){
        $user = DB::table('user_tbl')->where('email', request('email'))->first();
        if(!$user)
        return redirect()->back()->withErrors([
            'message'=> 'Email not found',
        ]);

        $newPass = Str::random(8);
        DB::table('user_tbl')
        ->where('email', request('email'))
        ->update(['password' => $newPass]);

        $body = 'Hi '.request('email');
        $body .=   '<br>';
        $body .=   'Here\'s your new password <br>';
        $body .=   $newPass.' <br>';
        $body .=   'Please do not reply to this email';

        \Mail::to(request('email'))->send(new \App\Mail\ForgetPassMail($body, 'inventory request'));
        return redirect()->back()->with('success', 'Request sent. Please check your email');
    }


    // logout
    function logout(){
        session()->flush();
        return redirect()->route('login');
    }



}

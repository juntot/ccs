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
use App\Services\FileHandle;

class AuthUserController extends Controller
{
    function __construct(){
        date_default_timezone_set("Asia/Hong_Kong");
    }

    function addUser(){
        $created_at = Carbon::now();
        // QrCode::backgroundColor(4, 114, 24);
        $qr = QrCode::size(200)
                ->eyeColor(0, 4, 114, 24, 0 ,0 ,0)
                ->eyeColor(1, 4, 114, 24, 0 ,0 ,0)
                ->eyeColor(2, 4, 114, 24, 0 ,0 ,0)
                ->generate(request('userId'));

        // filesave
        $regId = Carbon::now()->valueOf();
        $filepath = FileHandle::fileAttachment(Carbon::now()->isoFormat('YYYY'), request('userId'));


        request()->merge([
            'qrcode' => $qr,
            'avatar' => $filepath,
            'created_by' => UserSession::getUserId(),
            'created_at' => Carbon::now(),
            'password' => Hash::make('1234'),
        ]);
        
        
        try {
            $db = DB::table('user_tbl')->insert(request()->except('_token', 'attachment'));
            return $qr;
        } catch (\Throwable $th) {
            
            return \Response::json(array(
                'code'      =>  401,
                'message'   => 'Duplicate Record'
            ), 401);
        }
        
    }

    function updateUser(){
        
        $filepath = FileHandle::fileAttachment(Carbon::now()->isoFormat('YYYY'), request('userId'));
        
        if($filepath)
        request()->merge([
            'avatar' => $filepath,
        ]);

        DB::table('user_tbl')
            ->where('userId', request('userId'))
            ->update(request()->except('_token', 'attachment'));
            
        return request()->all();
    }

    function removeUser(){
        DB::table('user_tbl')
            ->where('userId', request('userId'))
            ->delete();

        FileHandle::delAttachment(request('avatar'));
        return http_response_code(200);
    }

    function getUsers(){

        $authusersection = session()->get('auth.section');
        $result = [];
        
        $result = DB::table('user_tbl as user')
                ->leftJoin('section_tbl as section', 'user.section', '=', 'section.sectionId')
                ->select('user.userId','user.avatar', 'user.qrcode', 'user.fullname', 'section.SectionName',
                'user.section', 'user.guardian', 'user.guardian_contact', 'user.role');
        
        $sections = DB::table('section_tbl')
                ->orderBy('SectionName', 'asc')
                ->get();
        // if(session()->get('auth.userId') == 'encoder'){
        //     $result = $result
        //               ->where('userId', '<>', 'admin')
        //               ->where('userId', '<>', 'sudo')
        //               ->where('userId', '<>', 'encoder')
        //               ->where('userId', '<>', 'scanner')
        //               ->get();
        // }
        // else 
        // 1 is for admin
        if(session()->get('auth.role') == 1){
            $result = $result
                      ->where('userId', '<>', 'sudo')                      
                      ->get();
        }
        else if(session()->get('auth.userId') == 'admin'){
            $result = $result
                      ->where('userId', '<>', 'sudo')                      
                      ->get();
        }
        else if(session()->get('auth.userId') == 'sudo'){
            $result = $result
                      ->get();
        }   
        // 2 is for teacher
        else if(session()->get('auth.role') == 2){
            $result = $result
                    ->where('section', $authusersection)
                    ->where('role', 0)
                    ->get();
        }
        return view('users', compact('result', 'sections'));
    }
    
    // login
    function login(){
        
        $user = DB::table('user_tbl')
                ->where('userId', request('userId'))
                ->where('role', '>=', 1)
                ->first();

        if($user && Hash::check(request('password'), ($user->password)))
        {
            session([
                     'auth.userId'    => $user->userId, 
                     'auth.role'     => $user->role, 
                     'auth.fullname' => $user->fullname,
                     'auth.section' => $user->section
                    ]);
                    
            // return redirect()->route('home');
            // return \Redirect::intended('defaultpage');
            return redirect()->intended('/');
        }

        request()->flash();
        return redirect()->back()->withErrors([
            'message'=> 'Invalid user or password',
        ]);
    }

    // login view
    function loginView(){
        if(session()->get('auth.userId')){
            return redirect()->route('home');
        }else{
            return view('/login');
        }
    }

    // change pass user define
    function changePassUserDefine(){
        request()->validate([
            'password' => 'required|min:6'
        ]);

        $user = DB::table('user_tbl')->where('userId', request('userId'))->first();
        
        DB::table('user_tbl')
        ->where('userId', $user->userId)
        ->update(['password'=> Hash::make(request('password'))]);


        return http_response_code(200);
        
    }

    // reset password
    function changePass(){
      
        // $user = DB::table('users')->where('empID', request('empID'))->get();
        request()->validate([
            'oldpass' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = DB::table('user_tbl')->where('userId', UserSession::getUserId())->first();
        if(Hash::check(request('oldpass'), ($user->password)))
        {
            DB::table('user_tbl')
            ->where('userId', UserSession::getUserId())
            ->update(['password'=> Hash::make(request('password'))]);


            session()->flush();
            return redirect()->route('login');
        }
        return back()->withErrors(['oldpass' => 'oldpass does not match from your old record']);
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

    // reset Users
    function resetUsers(){
        try {
            $user = DB::table('user_tbl')
            ->where('role', '=', 0)
            ->update(['section' => 0]);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => 'An error occured please try again.'
            ], 400); //
        }
        return http_response_code(200);
    }


    function getUncategorizeUsers(){
        $result = DB::table('user_tbl as user')
                ->leftJoin('section_tbl as section', 'user.section', '=', 'section.sectionId')
                ->select('user.userId','user.avatar', 'user.qrcode', 'user.fullname', 'section.SectionName',
                'user.section', 'user.guardian', 'user.guardian_contact', 'user.role')
                ->where('user.role',    '=', 0)
                ->where('user.section', '=', 0)
                ->get();
        
        return $result;
        // $sections = DB::table('section_tbl')->get();
    }

}

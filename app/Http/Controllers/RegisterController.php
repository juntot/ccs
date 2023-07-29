<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
class RegisterController extends Controller
{
    // view
    function registerView(){
        return view('register');
    }

    // register
    function register(){
        
        

        $validated = request()->validate([
            'fullName' => 'required|min:4|max:255',
            'email' => 'email:filter',
            'state' => 'required',
            'suburb' => 'required',
            'password' => 'required',
        ]);

        request()->merge([
            'password' => HasH::make(request('password'))
        ]);

        DB::table('user_tbl')->insertOrIgnore(request()->except('_token'));

        session(['auth.empID' => request('email'), 'auth.type' => 0]);
        return redirect()->route('home');
    }

}

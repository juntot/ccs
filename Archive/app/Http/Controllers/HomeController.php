<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // render home page
    function home(){
        if(session()->get('auth.email') && session()->get('auth.type') == 1){
            return view('admin');
        }
        if(session()->get('auth.email') && session()->get('auth.type') == 0){
            return view('home');
        }
    }
    
}

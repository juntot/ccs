<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class UserLogController extends Controller
{
    //
    function createRecord(){
        $carbonNow = Carbon::now();
        $diff = $carbonNow->diffInMinutes($someRandomFutureDateVariable);
    }
}

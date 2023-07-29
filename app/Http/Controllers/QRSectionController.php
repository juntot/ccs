<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class QRSectionController extends Controller
{
    //
    function viewSection(){
        // $authusersection = session()->get('auth.section');
        $result = [];
    
        $result = DB::table('section_tbl')
                ->orderBy('SectionName', 'desc')
                ->get();
        return view('sections', compact('result'));
    }

    function createSection(){
        
        $object = DB::table('section_tbl')->insertGetId(
            request()->except(['_token'])
        );

        
        return $object;
    }
    
    function updateSection(){
        
        DB::table('section_tbl')
            ->where('sectionId', request('sectionId'))
            ->update(request()->except('_token'));
            
        return request()->all();
    }

    function delSection(){
        DB::table('section_tbl')
        ->where('sectionId', request('sectionId'))
        ->delete();   
    }
}

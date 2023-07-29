<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function coverPage(){
        $name = '';
        $requestName = '';
        if(request()->has('attachment_main')){
            $name = 'hero-bg.jpg';
            $requestName = 'attachment_main';
        }else{
            $name = 'login-bg.jpg';
            $requestName = 'attachment_login';
        }

        $this->fileAttachment($requestName, $name);
        return http_response_code(200);
    }


    function fileAttachment($attachment = '', $name =''){
        $files = request()->file($attachment);
        $file_path = '';
        
        if(request()->has($attachment) && $files)
        {
            
                $ext = $files->getClientOriginalExtension();
                $filename = $name;
    
                if(\Storage::disk('local')->exists('public/'.$filename)){
                    \Storage::delete('public/'.$filename);
                    $path = $files->storeAs('public/', $filename);
                    $file_path =  $path;
                }else{
                    $path = $files->storeAs('public/', $filename);
                    $file_path =  $path;
                }
        }
        return $file_path;
      }
}

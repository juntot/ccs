<?php

// namespace App\Repository;
namespace App\Services;
use Carbon\Carbon;
class FileHandle{

    
  static function delAttachment($path){
    if(\Storage::disk('local')->exists($path)){
        \Storage::delete($path);
        return \Storage::deleteDirectory($path);
    }
    return 'false';
        
  }

  static function fileAttachments($folder = ''){
      $files = request()->file('attachment');
      $file_path = [];
      // return $files;
      if(request()->has('attachment') && $files)
      {
          foreach($files as $image)
          {
              // $filename = $image->getClientOriginalName();
              $ext = $image->getClientOriginalExtension();
              $filename = Carbon::now()->valueOf().'.'.$ext;

              if(\Storage::disk('local')->exists('public/'.$folder.'/'.$filename)){
                  \Storage::delete('public/'.$folder.'/'.$filename);
                  $path = $image->storeAs('public/'.$folder, $filename);

                  // $file_path[] = ['pdf_loc' => $path, 'empID_' => pathinfo($filename, PATHINFO_FILENAME)];
              }else{
                  $path = $image->storeAs('public/'.$folder, $filename);
                  $file_path[] =  $path;
              }
          }
      }
      return $file_path;
  }

  static function fileAttachment($folder = '', $name =''){
    $files = request()->file('attachment');
    $file_path = '';
    // return $files;
    if(request()->has('attachment') && $files)
    {
        
            $ext = $files->getClientOriginalExtension();
            $filename = $name.'.'.$ext;

            // if(\Storage::disk('local')->exists('public/'.$folder.'/'.$filename)){
            //     \Storage::delete('public/'.$folder.'/'.$filename);
            //     $path = $files->storeAs('public/'.$folder, $filename);
            //     $file_path =  $path;
            //     // $file_path[] = ['pdf_loc' => $path, 'empID_' => pathinfo($filename, PATHINFO_FILENAME)];
            // }else{
                $path = $files->storeAs('public/'.$folder, $filename);
                $file_path =  $path;
            // }
    }
    return $file_path;
  }

}

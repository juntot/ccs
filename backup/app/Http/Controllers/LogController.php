<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LogController extends Controller
{

    // get log
    function getLogs(){
        $keyword = '';
        $requestKeyword = request('keyword');
        if($requestKeyword == '')
        $requestKeyword = '*';
        

        if($requestKeyword == '*')
        $keyword = '%';
        
        if($requestKeyword != ''  && $requestKeyword != '*')
        $keyword = $requestKeyword.'%';


        $sql =  'select log._userId, log.date_created, log.status, log.sms, log.badnum,
        user.avatar, user.fullname, sect.SectionName as section, user.guardian, user.guardian_contact
        from user_log log
        join user_tbl user
            on log._userId = user.userId
        left join section_tbl sect
            on user.section = sect.sectionId
        WhERE
            log.badnum = 0';

        
        if(session()->get('auth.role') == 2){
            $sql = $sql.'
            AND sect.sectionId = '.session()->get('auth.section');
        }
        


        $result = DB::select($sql.
                    '
                    AND
                        (log.date_created BETWEEN :dateFrom AND :dateTo)
                    AND
                    (log._userId like :search or LOWER(sect.SectionName) like :search2)',
                    [request('datefrom'), 
                    request('dateto'), 
                    $keyword, strtolower($keyword)]);
                    // SELECT * FROM `user_log` WHERE date_created BETWEEN '2022-06-04 00:00:00' and '2022-06-04 23:59:59';
                    // AND
                    // _userId like :search
        return $result;

    }

}

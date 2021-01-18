<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    public function getBaseURL(Request $request){
        $url = $request->url; 
        $ch = curl_init($url); 
        curl_setopt($ch,CURLOPT_HEADER,true); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false); 
        $data = curl_exec($ch); 
        $pdata = $this->http_parse_headers($data); 
        return $pdata;
    }
    function http_parse_headers( $header )
    {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        $s = str_replace("\n",'', $fields[sizeof($fields)-1]);
        $a = strstr($s, 'window.location.href');
        $b = strstr($a, '.html',true);
        $c = strstr($b, 'https');
        if (empty($c)){
            return 'false';
        }
        return $c.'.html';
    }
}

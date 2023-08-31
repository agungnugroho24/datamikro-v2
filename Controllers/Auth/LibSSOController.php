<?php

namespace App\Http\Controllers\Auth; //Namespace bisa disesuaikan dengan letak file ini,, idealnya di dlm folder Auth

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;

class LibSSOController extends Controller
{

    var $app        = 'datamikrov2';
    var $apikey     = 'EdCgC43CpGi3Lo67io47HCAG5sYU+oUOVU2jKPgCtJSTA34fhGSbray3ix79jA3%21H6v5mPeeH1gjZ+a0kM6ceg==';
    var $sess_id    = '';


    public function __construct()
    {
        if(! isset($_COOKIE['um-bp'])):
            $this->sess_id = null;
        else:
            $cookies = $_COOKIE['um-bp']; 
            $this->sess_id = substr($cookies, strpos($cookies, "32:") + 4, 32);            
        endif;

        return $this->sess_id;
    }

    public function setCookies(){
        if(! isset($_COOKIE['um-bp'])):
            $this->sess_id = null;
        else:
            $cookies = $_COOKIE['um-bp']; 
            $this->sess_id = substr($cookies, strpos($cookies, "32:") + 4, 32);            
        endif;

        return $this->sess_id;
    }

    public function getData(){
        $sess_id = $this->setCookies();
        $isian = array( 'session' => $sess_id,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/checkSession";
        return $this->postData($isian, $url);
    } 

    public function deleteSession(){
        $isian = array( 'session' => $this->sess_id,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/deleteSession";
        unset($_COOKIE["um-bp"]);
        return $this->postData($isian, $url);
        
    }

    public function getOneStepAhead($username){
        if(!empty($username)){
            $isian = array( 'username' => $username,
                            'app'      => $this->app,
                            'apikey'   => $this->apikey);
            $url = "https://akun.bappenas.go.id/bp-um/service/getUserBoss";
            //unset($_COOKIE["um-bp"]);
            return $this->postData($isian, $url);
        }else{
            return false;
        }
    }

    public function getUserapp(){
        $isian = array( 'username' => $this->getData()->data[0]->userid,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/getUserApp";
        return $this->postData($isian, $url);
    }

    public function getuserdata($uid){
        $isian = array( 'username' => $uid,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/checkUser";
        return $this->postData($isian, $url);
    }

    private function postData($data, $url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);
        $hasil = json_decode($output);
        return $hasil;
        // dd($hasil);
    }



}

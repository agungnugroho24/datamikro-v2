<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LibSSOController;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginSSOController extends Controller
{
    use AuthenticatesUsers;

    public function login()
    {
        $libcontrol = new LibSSOController;
        $data = $libcontrol->getData();

        if (empty($data->data)) {
            return redirect()->to('http://akun.bappenas.go.id/bp-um/service/front/datamikrov2/EdCgC43CpGi3Lo67io47HCAG5sYU+oUOVU2jKPgCtJSTA34fhGSbray3ix79jA3%21H6v5mPeeH1gjZ+a0kM6ceg==')->send();
        } else {
            if (empty($data->userdata)) {
                $this->logout();
            } else {
                $response = $this->process_login($data->userdata, $data->usermail);
                if ($response){
                    return redirect()->route('home');
                }else{
                    // return redirect()->route('gagal_login_belum_terdaftar');
                    $this->logout();
                }
            }
        }
    }



    private function process_login($userdata, $email)
    {
        $request = new Request;

        $query = User::where('username', '=', $userdata[0]->user_name)->first();

        if ($query != null){
            if (strlen($userdata[0]->id_uke_bsdm) > 4) {
                $iduke = substr($userdata[0]->id_uke_bsdm, 0, 4);
            } else {
                $iduke = $userdata[0]->id_uke_bsdm;
            }
            $user = User::find($query->id);
            $user->name = $userdata[0]->nama;
            $user->nip = $userdata[0]->nip;
            $user->iduke = $iduke;
            $user->jabatan = $userdata[0]->jabatan_akhir;
            $user->status = '1';
            $user->save();

            $sess_data = array(                
                'username'  => $userdata[0]->user_name,
                'email'     => $email,
                'nama'      => $userdata[0]->nama,
                'nip'       => $userdata[0]->nip,
                'nama_uke'  => $userdata[0]->unit_kerja,
                'iduke'     => $iduke,  
                'avatar'    => $userdata[0]->avatar,
                'isorganik' => $userdata[0]->isorganik,
                'login'     => TRUE,
                'jabatan'   => $userdata[0]->jabatan_akhir,
            );
            Session::put('userdata', $sess_data);

            Auth::loginUsingId($query->id);
            Auth::user()->before_last_login_at = Auth::user()->last_login_at;
            Auth::user()->last_login_at = Carbon::now()->toDateTimeString();
            Auth::user()->last_login_ip = $request->getClientIp();
            Auth::user()->save();

            return TRUE;
        }else{
            if (strlen($userdata[0]->id_uke_bsdm) > 4) {
                $iduke = substr($userdata[0]->id_uke_bsdm, 0, 4);
            } else {
                $iduke = $userdata[0]->id_uke_bsdm;
            }
            $user = new User();
            $user->email = $email;
            $user->name = $userdata[0]->nama;
            $user->nip = $userdata[0]->nip;
            $user->username = $userdata[0]->user_name;
            $user->iduke = $iduke;
            $user->jabatan = $userdata[0]->jabatan_akhir;
            $user->save();   
            if ($userdata[0]->isorganik==true) {
                DB::table('role_user')->insert(['role_id'=>'5', 'user_id'=>$user->id, 'user_type'=>'App\Models\User']);
            }         
            
            $sess_data = array(                
                'username'  => $userdata[0]->user_name,
                'email'     => $email,
                'nama'      => $userdata[0]->nama,
                'nip'       => $userdata[0]->nip,
                'nama_uke'  => $userdata[0]->unit_kerja,
                'iduke'     => $iduke,  
                'avatar'    => $userdata[0]->avatar,
                'isorganik' => $userdata[0]->isorganik,
                'login'     => TRUE,
                'jabatan'   => $userdata[0]->jabatan_akhir,
            );
            Session::put('userdata', $sess_data);

            Auth::loginUsingId($user->id);
            Auth::user()->before_last_login_at = Auth::user()->last_login_at;
            Auth::user()->last_login_at = Carbon::now()->toDateTimeString();
            Auth::user()->last_login_ip = $request->getClientIp();
            Auth::user()->save();

            return TRUE; 
        }
        //end checking user status
    }

    public function logout()
    {
        $libcontrol = new LibSSOController;
        $libcontrol->deleteSession();
        Auth::logout();
        Session::flush();

        return redirect()->to('http://akun.bappenas.go.id/bp-um/service/front/datamikrov2/EdCgC43CpGi3Lo67io47HCAG5sYU+oUOVU2jKPgCtJSTA34fhGSbray3ix79jA3%21H6v5mPeeH1gjZ+a0kM6ceg==')->send();
    }
}

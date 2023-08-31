<?php

namespace App\Http\Controllers;

use Exception;
use Cookie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Unitkerja;
use App\Models\Role;
use App\Models\Category;
use App\Models\CategoryFile;
use App\Models\Cart;
use App\Models\RequestDatas;
use App\Models\RequestDataFile;
use App\Models\Hasil;
use App\Models\NotAvailable;
use App\Models\RequestOther;
use App\Models\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;

class DtController extends Controller
{

	public function home(){
		return view('pages.home', [
			'category' => Category::whereNull('deleted_at')->get(),
			'notavailable' => NotAvailable::where('user_id', auth()->user()->id)->whereNull('request_other_id')->get()
		]);
	}

	public function riwayat(){
		return view('pages.permintaantersedia.riwayattersedia', [
			'data' => RequestDatas::where('user_id', auth()->user()->id)
					// ->where('request_status', 'pending')
					->where('step_done', '<', '5')
					->get()
		]);
	}

	public function listtersedia(){
		$data = RequestDatas::with(
				[
					'files' => function ($query) {
					$query->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id');},
					'hasils'
                ])
				->select('request_datas.*', 'u1.name', DB::raw('u2.name verifikasi'))
	            ->orderBy('request_datas.id', 'desc')
				->leftjoin(DB::raw('users u1'), 'u1.id', 'request_datas.user_id')
				->leftjoin(DB::raw('users u2'), 'u2.id', 'request_datas.acc_user')
				->get();
		return view('pages.permintaantersedia.listtersedia', [
			'data' => $data
		]);
	}

	public function convertDate($date,$format = 'm'){
		return date($format, strtotime($date));
	}

	public function dtlisttersedia(Request $request){
		if($request->ajax())
        {
			
			$output="";

			$data = RequestDatas::with(
					[
						'files' => function ($query) {
						$query->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id');},
						'hasils'
					])
					->select('users.*', 'request_datas.*', 'u1.name', DB::raw('u2.name verifikasi'))
					->orderBy('request_datas.id', 'desc')
					->leftjoin(DB::raw('users u1'), 'u1.id', 'request_datas.user_id')
					->leftjoin(DB::raw('users u2'), 'u2.id', 'request_datas.acc_user')
					->leftjoin('users','users.id','request_datas.user_id')
					->where('users.name', 'like', '%'.$request->search.'%')
					->orWhere('users.email', 'like', '%'.$request->search.'%')
					->paginate(10);
        
        	if($data->isNotEmpty())
            {
                foreach ($data as $dat)
                {
					$output.='<tr>'.
					'<td>'.'
						<a href="'.route('tracking', $dat->uuid).'">'.$dat->ladu_no.'/P02.SP/'.date('m', strtotime($dat->request_date)).'/'.date('Y', strtotime($dat->request_date)).'</a><br>
						Diajukan oleh:<br>
						<span class="label label-info">'.$dat->name.'</span><br>
						'.date('d M Y', strtotime($dat->request_date)).'
						<sup><br>'.date('H:i:s', strtotime($dat->request_date)).'</sup><br>
						<div class="lead"><a href="https://data.bappenas.go.id/cart/tracking/460" title="Rincian Langkah"><i class="glyphicon glyphicon-time"></i></a></div>
					'.'</td>'.
					'<td>'.'
						<b><i class="glyphicon glyphicon-check"></i> Penanggung Jawab Permintaan</b>
						<ul>
						<li>Nama: <b>'.$dat->responsible_name.'</b></li>
						<li>NIP: <b>'.$dat->responsible_nip.'</b></li>
						<li>UKE: <b>'.$dat->responsible_position.'</b></li>
						<!-- <li>Ext: <b></b></li> -->
						</ul>
						<b><i class="glyphicon glyphicon-check"></i> Kelengkapan Dokumen</b>
						<ul>
						<li>Nomor Nota Dinas: <b>'.$dat->nd_number.'</b></li>
						</ul>
						<b><i class="glyphicon glyphicon-check"></i> Abstraksi</b>
						<ul>
						<li>Judul: <b>'.$dat->abstract_title.'</b></li>
						<li>Isi: <b>'.$dat->abstract_content.'</b></li>
						<li>Penulis: <b>'.$dat->name.'</b></li>
						</ul>'.
					// '</td>'.
					// '<td>'.'
					// 	<span class="label label-success">'.$dat->request_status.'</span>'.
					'</td>';
					$output .= '<td><table class="table table-borderless">';
					foreach($dat->files as $files)
                    {                   
						$output .='<tr style="background-color: transparent;"><td>
							<div class="bd-example">
							'.$files->name.'<i> diunduh: <b>'.$files->download.'x</b></i></br>';
							
						$output .=	'</div></td></tr>';
                    }
					$output .= '</table></td><td><div class="row">';
					foreach($dat->hasils as $file)
					{
						if($file->type=='docx'){
							$filetype = 'doc';
						}else{
							$filetype = $file->type;
							$output .= '<div class="col"><a href="'.route('downloadhasil', $file->id).'"><img src="'.url('assets/img/filetype/'.$filetype).'.png" width="30" style=""></a></div>';
						}
					}
					$output .= '</div></td>';
					if($dat->request_status=='accept'){
						$output .= '<td>Diverifikasi oleh '.$dat->verifikasi.' pada '.$dat->acc_date.'
						<br>';
					}else{
						$output .= '
						<td>'.
						'
							<span class="label label-success">'.$dat->request_status.'</span>
						'
						.'</td>';
					}
					$output .= '
						<td>'.
						'<div class="bd-example">
						  <button type="button" class="btn btn-sm btn-info mb-1" onclick="modalLadu(\''.$dat->uuid.'\')">Cetak LADU</button>';
					$output .= '<button type="button" class="btn btn-sm btn-success mb-1"'; 
					if($dat->request_status=='accept') $output .= 'disabled';
					$output .= ' onclick="accept(\''.$dat->uuid.'\')">Aktifkan Link</button>';
					$output .= '<button type="button" class="btn btn-sm btn-danger mb-1"'; 
					if($dat->request_status=='reject') $output .= 'disabled'; 
					$output .= ' onclick="modal(\''.$dat->uuid.'\',\'reject\')">Reject</button>';
					$output .= '<button type="button" class="btn btn-sm btn-warning mb-1"'; 
					if($dat->request_status=='pending') $output .= 'disabled'; 
					$output .= ' onclick="modal(\''.$dat->uuid.'\',\'pending\')">Pending</button>';
					$output .= '<button type="button" class="btn btn-sm btn-primary mb-1"'; 
					if($dat->request_status=='complete') $output .= 'disabled'; 
					$output .= ' onclick="modal(\''.$dat->uuid.'\',\'complete\')"><i class="fa fa-check"></i>Complete</button>';
					if(($dat->request_status=='complete' || $dat->request_status=='accept') && date("Y-m-d H:i:s") > $dat->files[0]->expired){
						$output .= '<button type="button" class="btn btn-sm btn-info mb-1" onclick="modalExpired(\''.$dat->uuid .'\', \''.$dat->files[0]->expired.'\')"> Edit Expired</button>';
					}
					$output .=	'</div>'
						.'</td>';
					
                }
            	return Response($output);
            }
			else
			{
				$output.='<tr>'.
                '<td align="center" colspan="8">No Data Found</td>'.
                '</tr>';
			}
				return Response($output);
        }
	}

	public function listblmtersedia(){		
		$query = RequestOther::query()->with(['datas'])		
				->select('request_others.*', 'u1.name')
	            ->orderBy('request_others.id', 'desc')
				->leftjoin(DB::raw('users u1'), 'u1.id', 'request_others.user_id');
		if(auth()->user()->hasRole('user')){
			$query = $query->where('user_id', auth()->user()->id);
		}

		$data = $query->get();
		return view('pages.permintaanblmtersedia.listblmtersedia', [
			'data' => $data
		]);
	}

	public function datadasar(){
		return view('pages.datadasar.datadasar', [
			'category' => Category::whereNull('deleted_at')->paginate(10)
		]);
	}

	public function kategori(){
		return view('pages.kategori.kategori');
	}

	public function laporandata(){
		$data = Category::whereNull('deleted_at')->get();
		foreach ($data as $dat) {
			$dat['uke'] = CategoryFile::where('category_id', $dat->id)
					->whereNotNull('rd.id')
					->select('unitkerjas.name')
					->leftjoin(DB::raw('request_data_files rdf'), 'rdf.category_file_id', 'category_files.id')
					->leftjoin(DB::raw('request_datas rd'), 'rd.id', 'rdf.request_data_id')
					->leftjoin('users', 'users.id', 'rd.user_id')
					->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
					->groupBy('unitkerjas.id')
					->get();
		}
		return view('pages.laporandata.laporandata', [
			'data' => $data
		]);
	}
	
	public function laporanuser(){
		$data = RequestDatas::with(
				[
					'files' => function ($query) {
					$query->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id');},
					'hasils'
                ])
				->select('request_datas.*', 'u1.name', DB::raw('u2.name verifikasi'), DB::raw('unitkerjas.name uke'))
	            ->orderBy('request_datas.id', 'desc')
				->leftjoin(DB::raw('users u1'), 'u1.id', 'request_datas.user_id')
				->leftjoin(DB::raw('users u2'), 'u2.id', 'request_datas.acc_user')
				->leftjoin('unitkerjas', 'unitkerjas.iduke', 'u1.iduke')
				->get();
		return view('pages.laporanuser.laporanuser', [
			'data' => $data
		]);
	}

	public function log(){
		return view('pages.log.log');
	}

	public function custom(){
		return view('pages.permintaanblmtersedia.addcustom');
	}

	public function uke(){
		return view('pages.uke.uke',[
			'uke' => Unitkerja::leftjoin('unitkerjas as uk', 'uk.parent', '=', 'unitkerjas.id')
						->select('unitkerjas.*', DB::raw('count(uk.id) as total'))
						->groupBy('unitkerjas.id')
            			->get()
		]);
	}

	public function detail(Category $category){
		$data = Cart::where('user_id', auth()->user()->id)->get();
		$cart = array();
		foreach($data as $data){
            $cart[] = $data->category_file_id;
        }

        $log = new Log();
        $log->type = 'read';
        $log->data =  $category->name;
        $log->uke_id = auth()->user()->iduke;
        $log->username = auth()->user()->username;
        $log->category_id = $category->id;
        $log->save();

        $update = Category::find($category->id);
        $update->access = $category->access+1;
        $update->save();

		return view('pages.datamikro.detail', [
            'category' => $category,
            'cart' => $cart,
            'files' => CategoryFile::where('category_id', $category->id)
                        ->select('*', DB::raw('
                            (CASE WHEN size < 1000000 
                            THEN CONCAT(CEILING(size / 1024.0), " KB")
                            ELSE 
                            CONCAT(FORMAT(size / 1048576.0, "N3"), " MB")
                            END) AS filesize'))
                        ->get()]);
	}

	public function cart(Request $request)
	{
		$request->validate([
            "id" => "required",
        ]);

        $check = Cart::where('user_id', auth()->user()->id)->where('category_file_id', $request->id)->first();
        if ($check!=null) {
        	$check->delete();
        }else{        	
			$cart = new Cart();
			$cart->category_file_id = $request->id;
			$cart->user_id = auth()->user()->id;
			$save = $cart->save();
        }
		
		$total = Cart::where('user_id', auth()->user()->id)->count();

		return $total;
	}

	public function track(Request $request){
		$cookie = cookie('step_done', '', -1);
		return response(view('pages.cart.track'))->withCookie($cookie);
	}

	public function tracking($uuid){
		$data = RequestDatas::where('uuid', $uuid)->first();
		$cookie = array(
			'step_done' => $data->step_done,
			'id' => $data->id,
		);
		$minutes = 3600;
		return response(view('pages.cart.track', [
			'step_done' => json_encode($cookie),
		]))->withCookie(cookie('step_done', json_encode($cookie), $minutes));
	}

	public function step1(Request $request)
	{
		$cart = Cart::where('user_id', auth()->user()->id)
				->leftjoin('category_files', 'category_files.id', 'carts.category_file_id')
				->get();
		$isCookie = $request->cookie('step_done');
		$data = null;
		$request_data = null;
		if($isCookie!=null){
			$step = json_decode($isCookie);
			$data = RequestDataFile::where('request_data_id', $step->id)
					->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id')
					->get();
			$query = RequestDatas::query()->where('id', $step->id);
			if(auth()->user()->hasRole('user')){
				$query = $query->where('user_id', auth()->user()->id);
			}

			$request_data = $query->first();
		}

		return view('pages.cart.step1', [
			'cart' => $cart,
			'cookie' => $isCookie,
			'request_data' => $request_data,
			'data' => $data, 
		]);
	}

	public function step2(Request $request)
	{
		$isCookie = $request->cookie('step_done');
		$request_data = null;
		$uke = null;
		$isSusenas = null;
		$step = null;
		if($isCookie!=null){
			$step = json_decode($isCookie);
			if ($step->step_done==1) {
				$uke = User::where('users.id', auth()->user()->id)
						->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')->first();
				$isSusenas = Cart::where('user_id', auth()->user()->id)
							->leftjoin('category_files', 'category_files.id', 'carts.category_file_id')
							->leftjoin('categories', 'categories.id', 'category_files.category_id')
							->where('categories.id', '13')
							->first();
			}else{
				$query = RequestDatas::query()
						->where('request_datas.id', $step->id)
						->leftjoin('users', 'users.id', '=', 'request_datas.user_id');
				if(auth()->user()->hasRole('user')){
					$query = $query->where('request_datas.user_id', auth()->user()->id);
				}

				$request_data = $query->first();
			}
		}

		// EmailController::sendmail();

		return view('pages.cart.step2', [
			'uke' => $uke,
			'isSusenas' => $isSusenas,
			'cookie' => $isCookie,
			'request_data' => $request_data,
			'step' => $step
		]);
	}

	public function step3(Request $request)
	{
		$cart = Cart::where('user_id', auth()->user()->id)->get();
		$uke = User::where('users.id', auth()->user()->id)
				->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')->first();
		$request = RequestDatas::where('user_id', auth()->user()->id)
					->orderBy('id', 'DESC')
					->limit(1)
					->first();
		// dd($request);

		return view('pages.cart.step3', [
			'cart' => $cart,
			'uke' => $uke,
			'request' => $request,
		]);
	}

	public function step4(Request $request)
	{
		$isCookie = $request->cookie('step_done');
		$uke = null;
		$request = null;
		$files = null;
		if($isCookie!=null){
			$step = json_decode($isCookie);
			$uke = User::where('users.id', auth()->user()->id)
					->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')->first();
			
			$query = RequestDatas::query()
					->select('request_datas.*')
					->where('request_datas.id', $step->id)
					->leftjoin('users', 'users.id', '=', 'request_datas.user_id');
			if(auth()->user()->hasRole('user')){
				$query = $query->where('request_datas.user_id', auth()->user()->id);
			}

			$request = $query->first();
			if ($request!=null && $request->request_status=='accept') {
				$files = RequestDataFile::where('request_data_id', $request->id)
						->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id')
						->select('request_data_files.*', 'category_files.name')
						->get();
			}
		}
		// dd($request);

		return view('pages.cart.step4', [
			'uke' => $uke,
			'request' => $request,
			'cookie' => $isCookie,
			'files' => $files
		]);
	}

	public function step5(Request $request)
	{
		$isCookie = $request->cookie('step_done');
		$request = null;
		$hasil = null;
		if($isCookie!=null){
			$step = json_decode($isCookie);
			$query = RequestDatas::query()
					->where('request_datas.id', $step->id)
					->leftjoin('users', 'users.id', '=', 'request_datas.user_id');
			if(auth()->user()->hasRole('user')){
				$query = $query->where('request_datas.user_id', auth()->user()->id);
			}

			$request = $query->first();
			$hasil = Hasil::where('request_data_id', $step->id)
					->select('*', DB::raw('
                            (CASE WHEN size < 1000000 
                            THEN CONCAT(CEILING(size / 1024.0), " KB")
                            ELSE 
                            CONCAT(FORMAT(size / 1048576.0, "N3"), " MB")
                            END) AS filesize'))
					->get();
		}

		return view('pages.cart.step5', [
			'request' => $request,
			'hasil' => $hasil,
		]);
	}

	public function requestData(Request $request)
	{
		if ($request->step==1) {
			$data = array(
				'step_done' => 1,
				'id' => 0,
			);
			$minutes = 3600;
			$response = new Response(1);
			$response->withCookie(cookie('step_done', json_encode($data), $minutes));
			return $response;
		}elseif ($request->step==2) {	
			$last = RequestDatas::whereRaw('year(request_date)', 'year(curdate())')
					->whereNotNull('ladu_no')
					->select('ladu_no')
					->orderBy('id', 'desc')
					->limit(1)
					->first();
			$uke = User::where('users.id', auth()->user()->id)
					->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')->first();
			$cart = Cart::where('user_id', auth()->user()->id)->get();
			if ($last==null) {
				$ladu_no = 1;
			}else{
				$ladu_no = $last->ladu_no+1;
			}
			DB::beginTransaction();
			try{
				$check = new RequestDatas();
				$check->uuid = Str::uuid()->toString();
				$check->user_id = auth()->user()->id;
				$check->ladu_no =  $ladu_no;
				$check->responsible_name = $uke->responsible;
				$check->responsible_position = $uke->position;
				$check->responsible_nip = $uke->nip;
				$check->step_done = 2;
				$check->request_date = date("Y-m-d H:i:s");
				$check->created_by = auth()->user()->id;
				if (isset($request->variable)) {
					$check->variable = $request->variable;
				}				
				$check->kode_arsip = $request->kode_arsip;
				$check->abstract_title = $request->abstract_title;
				$check->abstract_content = $request->abstract_content;
				$check->save();

				foreach ($cart as $key) {
					$request_file = new RequestDataFile();
					$request_file->request_data_id = $check->id;
					$request_file->category_file_id = $key->category_file_id;
					$request_file->save();
				}

				$data = array(
					'step_done' => 2,
					'id' => $check->id,
				);
				$minutes = 3600;
				$response = new Response(1);
				$response->withCookie(cookie('step_done', json_encode($data), $minutes));

				Cart::where('user_id', auth()->user()->id)->delete();
				DB::commit();

				return $response;
			}catch(Exception $e){
				DB::rollback();
				echo 0;
			}
		}elseif ($request->step==4) {
			$cookie = json_decode($request->cookie('step_done'));	
			$step = $cookie->id;
			$check = RequestDatas::where('id', $step)
					// ->orderBy('id', 'DESC')
					// ->limit(1)
					->first();
			
			if ($check!=null) {
				DB::beginTransaction();
				try{
					if($check->request_status=='pending') {
						$check->step_done = 3;
						$check->updated_by = auth()->user()->id;
						$check->nd_number = $request->nd_number;
						$check->save();
						DB::commit();

						$data = array(
							'step_done' => 2,
							'id' => $check->id,
						);
						$minutes = 3600;
						$response = new Response(1);
						$response->withCookie(cookie('step_done', json_encode($data), $minutes));
					}elseif($check->request_status=='accept'){
						$check->step_done = 4;
						$check->updated_by = auth()->user()->id;
						$check->save();
						DB::commit();

						$data = array(
							'step_done' => 4,
							'id' => $check->id,
						);
						$minutes = 3600;
						$response = new Response(1);
						$response->withCookie(cookie('step_done', json_encode($data), $minutes));
					}else{
						$response = 0;
					}
					return $response;
				}catch(Exception $e){
					DB::rollback();
					echo 0;
				}
			}else{	
				echo 0;		
			}
		}else{
			echo 0;
		}
	}

	public function accept($uuid)
	{
		if ($uuid) {
			$check = RequestDatas::where('uuid', $uuid)->first();
			if ($check!=null) {
				$files = RequestDataFile::where('request_data_id', $check->id)
						->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id')
						->select('request_data_files.*', 'category_files.name')
						->get();
				DB::beginTransaction();
				try{
					$check->updated_by = auth()->user()->id;
					$check->acc_user = auth()->user()->id;
					$check->acc_date = date("Y-m-d H:i:s");
					$check->request_status = 'accept'; 
					$check->save();

					foreach ($files as $file) {
						$request_data_file = RequestDataFile::find($file->id);
						$request_data_file->token = md5($file->name.date("Y-m-d H:i:s").$uuid);
						$request_data_file->expired = DB::raw('now() + interval 5 day');
						$request_data_file->save();
					}
					DB::commit();
				}catch(Exception $e){
					DB::rollback();
				}
			}
		}
		return redirect()->route('listtersedia');	
	}

	public function complete($uuid)
	{
		if ($uuid) {
			$check = RequestDatas::where('uuid', $uuid)->first();
			if ($check!=null) {
				DB::beginTransaction();
				try{
					$check->updated_by = auth()->user()->id;
					$check->request_status = 'complete'; 
					$check->save();
					DB::commit();
				}catch(Exception $e){
					DB::rollback();
				}
			}
		}
		return redirect()->route('listtersedia');	
	}

	public function status(Request $request)
	{
		if(isset($request->uuid) && isset($request->status))  {
			$check = RequestDatas::where('uuid', $request->uuid)->first();
			if ($check!=null) {
				DB::beginTransaction();
				try{
					$check->updated_by = auth()->user()->id;
					$check->request_status = $request->status;
					$check->notes = $request->notes; 
					$check->save();
					DB::commit();
					return redirect()->route('listtersedia');
				}catch(Exception $e){
					DB::rollback();
					echo 0;
				}
			}
		}else{
			echo 0;
		}
	}

	public function expired(Request $request)
	{
		// dd($request);
		if(isset($request->id) && isset($request->date))  {
			$check = RequestDatas::where('uuid', $request->id)->first();
			if ($check!=null) {
				$files = RequestDataFile::where('request_data_id', $check->id)
						->get();
				DB::beginTransaction();
				try{
					foreach ($files as $file) {
						$request_data_file = RequestDataFile::find($file->id);
						$request_data_file->expired = $request->date;
						$request_data_file->save();
					}
					DB::commit();
					return redirect()->route('listtersedia');
				}catch(Exception $e){
					DB::rollback();
					dd($e);
					echo 0;
				}
			}
		}else{
			echo 0;
		}
	}

	public function download($token)
	{
		if($token){
			$check = RequestDataFile::where('token', $token)
					->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id')
					->select('request_data_files.*', 'category_files.path', 'category_files.name', 'category_files.category_id')
					->first();
			if($check){
				DB::beginTransaction();
				try{
					$request_data_file = RequestDataFile::find($check->id);
					$request_data_file->download = $check->download+1;
					$request_data_file->save();

			        $log = new Log();
			        $log->type = 'download';
			        $log->data =  $check->name;
			        $log->uke_id = auth()->user()->iduke;
			        $log->username = auth()->user()->username;
			        $log->category_id = $check->category_id;
			        $log->save();

			        $update = CategoryFile::find($check->category_file_id);
			        $update->download = $update->download+1;
			        $update->save();

					DB::commit();
					return Storage::download($check->path);	
				}catch(Exception $e){
					DB::rollback();
					return abort(404);
				}	
			}else{
				return abort(404);
			}	
		}else{
			return abort(404);
		}
	}

	public function downloadHasil($id)
	{
		if($id){
			$check = Hasil::where('id', $id)
					->first();
			if($check){
				return Storage::download($check->path);
			}else{
				return abort(404);
			}	
		}else{
			return abort(404);
		}
	}

	public function uploadFile(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'files' => 'required',
        ]);

        $folder = 'public/files';

        if($request->hasfile('files'))
        {
            foreach($request->file('files') as $key => $file)
            {
                $name = $this->generateName($folder.'/'.$file->getClientOriginalName());
                $path = $file->storeAs($folder, basename($name));
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $hasil = new Hasil();
                $hasil->request_data_id = $request->id;
                $hasil->name = basename($name);
                $hasil->size = $size;
                $hasil->type = $extension;
                $hasil->path = $path;
                $hasil->created_by = auth()->user()->id;
                $hasil->save();
            }
        }

        echo 1;
    }

    public function deletefile(Request $request)
    {
        $file = Hasil::find($request->id);
        $delete = $file->delete();
        if ($delete==1) {
            Storage::delete($file->path);
        }
        return $delete;
    }

    public function generateName($fileName)
    {
        if (Storage::exists($fileName)) {
            $pathInfo = pathinfo($fileName);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';

            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                $base = $pathInfo['filename'];
                $number = 0;
            }

            do {
                $fileName = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $base . ++$number . $extension;
            } while (Storage::exists($fileName));
        }

        return $fileName;
    }

    public function addData(Request $request)
	{       	
       	try{
			$notavailable = new NotAvailable();
			$notavailable->name = $request->nama;
			$notavailable->tahun = $request->tahun;
			$notavailable->cakupan = $request->cakupan;
			$notavailable->latarbelakang = $request->latarbelakang;
			$notavailable->tujuan = $request->tujuan;
			$notavailable->metode = $request->metode;
			$notavailable->jenis = $request->jenis;
			$notavailable->variabel = $request->variabel;
			$notavailable->rentangwaktu = $request->rentangwaktu;
			$notavailable->hasil = $request->rancanganhasil;
			$notavailable->keterangan = $request->keterangan;
			$notavailable->user_id = auth()->user()->id;
			$save = $notavailable->save();
			
			echo 1;	
       	}catch(\Exception $e){
       		echo 0;
	    }
	}

	public function requestOther(Request $request)
	{
		$notavailable = NotAvailable::where('user_id', auth()->user()->id)
						->whereNull('request_other_id')
						->get();
		DB::beginTransaction();
		try{
			$check = new RequestOther();
			$check->user_id = auth()->user()->id;
			$check->request_date = date("Y-m-d H:i:s");
			$check->created_by = auth()->user()->id;
			$check->save();

			foreach ($notavailable as $key) {
				$request_file = NotAvailable::find($key->id);
				$request_file->request_other_id = $check->id;
				$request_file->save();
			}

			DB::commit();

			echo $check->id;
		}catch(Exception $e){
			DB::rollback();
			echo 0;
		}			
	}

	public function delOther(Request $request)
	{
		DB::beginTransaction();
		try{
			RequestOther::where('id', $request->id)->delete();

			DB::commit();

			echo $check->id;
		}catch(Exception $e){
			DB::rollback();
			echo 0;
		}		
	}

	public function statusOther(Request $request)
	{
		$request_file = RequestOther::find($request->id);
		if ($request_file!=null) {
			$bps_check = array();
			if($request_file->bps_check!=null) {
				$bps_check = json_decode($request_file->bps_check);
			}

			$data = array(
				'status' => $request->bps_status,
				'date' => date("Y-m-d H:i:s")
			);

			array_push($bps_check, $data);

			DB::beginTransaction();
			try{
				$request_file->bps_check = json_encode($bps_check);
				$request_file->save();

				DB::commit();

				echo $request_file->id;
			}catch(Exception $e){
				DB::rollback();
				echo 0;
			}	
		}else{
			echo 0;
		}
	}

	public function suratOther(Request $request)
	{
		$request_file = RequestOther::find($request->id);
		if ($request_file!=null) {
			$folder = 'public/files';
			$name = $request_file->id . '_P02.SP_' . date('m', strtotime($request_file->request_date)) . '_' . date('Y', strtotime($request_file->request_date));

	        if($request->hasfile('scan_surat'))
	        {
                $extension = $request->scan_surat->getClientOriginalExtension();
                $uname = $folder.'/'.$name.'.'.$extension;
                $path = $request->scan_surat->storeAs($folder, basename($uname));
	        }

			DB::beginTransaction();
			try{
				$request_file->scan_surat = $uname;
				$request_file->save();

				DB::commit();

				echo $request_file->id;
			}catch(Exception $e){
				DB::rollback();
				echo 0;
			}	
		}else{
			echo 0;
		}
	}

	public function downloadSurat($id)
	{
		if($id){
			$check = RequestOther::where('id', $id)
					->first();
			if($check){
				return Storage::download($check->scan_surat);
			}else{
				return abort(404);
			}	
		}else{
			return abort(404);
		}
	}

	public function dtlog(Request $request){
		if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
					$data = Log::leftjoin('users', 'users.username', 'logs.username')
					->leftjoin('categories', 'categories.id', 'logs.category_id')
					->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
					->select('logs.*', 'users.name', 'unitkerjas.name as uke_name')
                    ->where('users.username', 'like', '%'.$request->search.'%')
                    ->paginate(10);
            }else{
                $data = Log::leftjoin('users', 'users.username', 'logs.username')
				->leftjoin('categories', 'categories.id', 'logs.category_id')
				->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
				->select('logs.*', 'users.name', 'unitkerjas.name as uke_name')
				->orderBy('logs.id', 'desc')
                ->paginate(10);
            }
            
            $total_row = $data->count();
            $grand_total = $data->total();
            if($total_row > 0)
            {
                foreach($data as $dat)
                {
					$now = date('Y-m-d');
					$date = date('Y-m-d', strtotime($dat->created_at));
					$time = date('H:i:s', strtotime($dat->created_at));
					if($dat->type=='login'){
					$activity = 'User login ke sistem';
					}else if($dat->type=='create'){
					$activity = 'Create data <b>'.$dat->data.'</b>';
					}else if($dat->type=='update'){
					$activity = 'Update data <b>'.$dat->data.'</b>';
					}else if($dat->type=='delete'){
					$activity = 'Delete data <b>'.$dat->data.'</b>';
					}else if($dat->type=='read'){
					$activity = 'Membaca data <b>'.$dat->data.'</b>';
					}else if($dat->type=='download'){
					$activity = 'Download data <b>'.$dat->data.'</b>';
					}
                    $output .= '
                    <tr>
                        <td>';
						if($now==$date)
						{
						$output .= $time;
						}else{
						$output .= ''.$date.' <sup>'.$time.'</sup>';
						}
						$output .= '</td><td>';
						$output .= ''.$dat->name.'</td><td>';
						$output .= ''.$activity.'</td><td>';
						$output .= ''.$dat->uke_name.'</td>';
                        $output .= '</tr>';
                }
            }
            else
            {
                $output = '
                <tr>
                <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
                $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row,
                'grand_total'  => $grand_total
            );
            echo json_encode($data);
        }
	}

	public function search(Request $request)
    {
        if(!empty($request)){
        $query = $request->all();
        $data = Log::leftjoin('users', 'users.username', 'logs.username')
		->leftjoin('categories', 'categories.id', 'logs.category_id')
		->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
		->select('logs.*', 'users.name', 'unitkerjas.name as uke_name')
		->orderBy('logs.id', 'DESC');
            if(isset($request->name) AND $request->name != 'all')
        $data = $data->where('logs.username', 'like', "%" .$request->name. "%");
		$data = $data->orWhere('unitkerjas.name', 'like', "%" .$request->name. "%");
        $data = $data->paginate(10);
        return view('pages.log.log', compact('data','query'));
        }

        $resource = Log::leftjoin('users', 'users.username', 'logs.username')
			->leftjoin('categories', 'categories.id', 'logs.category_id')
			->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
			->select('logs.*', 'users.name', 'unitkerjas.name as uke_name')
			->orderBy('logs.id', 'DESC')
            ->paginate(10);
        return view('pages.log.log', compact('data'));
        
    }

	public function search2(Request $request)
    {
        if($request->ajax())
        {
			$output="";

			$log = Log::leftjoin('users', 'users.username', 'logs.username')
					->leftjoin('categories', 'categories.id', 'logs.category_id')
					->leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
					->select('logs.*', 'users.name', 'unitkerjas.name as uke_name')
					->where('logs.username', 'like', '%'.$request->search.'%')
					->orderBy('logs.id', 'DESC')
					->paginate(10);
        
			if($log->isNotEmpty())
            {
                foreach($log as $dat)
                {
					$now = date('Y-m-d');
					$date = date('Y-m-d', strtotime($dat->created_at));
					$time = date('H:i:s', strtotime($dat->created_at));
					if($dat->type=='login'){
					$activity = 'User login ke sistem';
					}else if($dat->type=='create'){
					$activity = 'Create data <b>'.$dat->data.'</b>';
					}else if($dat->type=='update'){
					$activity = 'Update data <b>'.$dat->data.'</b>';
					}else if($dat->type=='delete'){
					$activity = 'Delete data <b>'.$dat->data.'</b>';
					}else if($dat->type=='read'){
					$activity = 'Membaca data <b>'.$dat->data.'</b>';
					}else if($dat->type=='download'){
					$activity = 'Download data <b>'.$dat->data.'</b>';
					}
                    $output .= '
                    <tr>
					<td>';
					if($now==$date)
					{
					$output .= $time;
					}else{
					$output .= ''.$date.' <sup>'.$time.'</sup>';
					}
					$output .= '</td><td>';
					$output .= ''.$dat->name.'</td><td>';
					$output .= ''.$activity.'</td><td>';
					$output .= ''.$dat->uke_name.'</td>';
					$output .= '</tr>';
                }
            return Response($output);
            }
			else
			{
				$output.='<tr>'.
                '<td align="center" colspan="8">No Data Found</td>'.
                '</tr>';
			}
			return Response($output);
        }
    }

	public function home2(){
		return view('pages.old-home', [
			'category' => Category::whereNull('deleted_at')->get(),
			'notavailable' => NotAvailable::where('user_id', auth()->user()->id)->whereNull('request_other_id')->get()
		]);
	}
	
}
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
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EmailController;

class LinkController extends Controller
{

	public function index(){
		$data = RequestDatas::with(
			[
				'files' => function ($query) {
				$query->leftjoin('category_files', 'category_files.id', 'request_data_files.category_file_id');},
				'hasils'
			])
			->select('request_datas.*', 'u1.name','request_data_files.expired')
			->orderBy('request_datas.id', 'desc')
			->leftjoin(DB::raw('users u1'), 'u1.id', 'request_datas.user_id')
			->leftjoin('request_data_files','request_data_files.request_data_id','request_datas.id')
			->paginate(10);
		return view('pages.link.index', [
			'data' => $data
		]);
	}
	
}
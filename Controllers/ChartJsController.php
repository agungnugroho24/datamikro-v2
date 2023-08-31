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
use App\Models\Metadata;
use App\Models\Tag;
use App\Models\CategoryTag;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;

class ChartJsController extends Controller
{

	public function index()
    {
        $month = ['Juli','Agustus','September'];

        $request_datas = [];
        foreach ($month as $key => $value) {
            $request_datas[] = RequestDatas::where(\DB::raw("DATE_FORMAT(created_at, '%M')"),$value)->count();
        }

    	return view('pages.permintaantersedia.tes')->with('month',json_encode($month,JSON_NUMERIC_CHECK))->with('request_datas',json_encode($request_datas,JSON_NUMERIC_CHECK));
    }
	
}
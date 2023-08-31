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
use Illuminate\Http\Response;
use App\Mail\SendMail;
use App\Mail\SendMail2;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

	public function index(){
		$user = DB::table('users')->having('recipient', 1)->Paginate(10);
                return view('pages.email.index', ['user' => $user]);
	}

	public function user(){
		$user = User::leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
			->leftjoin('role_user as ru', 'ru.user_id', 'users.id')
			->leftjoin('roles', 'roles.id', 'ru.role_id')
			->select('users.*', 'unitkerjas.name as uke_name', 'roles.display_name as role')
			->orderBy('users.id')
            ->paginate(10);
		return view('pages.user.user',[
			'user' => $user
		]);
	}

	public function fuser(User $user){
		return view('pages.user.form_user',[
			'user' => User::leftjoin('unitkerjas as uk', 'uk.iduke', '=', 'users.iduke')
						->leftjoin('role_user as ru', 'ru.user_id', 'users.id')
						->leftjoin('roles', 'roles.id', 'ru.role_id')
						->select('users.*', 'uk.name as uke', 'roles.id as role_id')
						->where('username', '=', $user->username)->first(),
			'role' => Role::all()
		]);
	}

	public function editUser(Request $request, User $user)
	{		
        $role = DB::table('role_user')->where('user_id', '=', $user->id)->first();
        if($role==null && $request->role!=0){
        	DB::table('role_user')->insert(['role_id'=>$request->role, 'user_id'=>$user->id, 'user_type'=>'App\Models\User']);
        }else if($role!=null && $request->role==0){
        	DB::table('role_user')->where('user_id', $user->id)->delete();
        }else if($role!=null && $request->role!=0){
			DB::table('role_user')->where('user_id', $user->id)->update(['role_id' => $request->role]);
        }
        return redirect()->route('user')->with('success', 'Berhasil mengubah data');
	}

	public function search(Request $request)
	{
		if($request->ajax())
		{
			$output = '';
			$query = $request->get('query');
			if($query != '')
			{
			$user = DB::table('users')
					->where('name', 'like', '%'.$query.'%')
					->orWhere('email', 'like', '%'.$query.'%')
					->having('recipient', 1)
					->paginate(10);
			}
			else
			{
				$user = DB::table('users')
				->where('recipient', 1)
				->paginate(10);
			}
				$total_row = $user->count();
				$grand_total = $user->total();
				if($total_row > 0)
			{
				$i = 1;
				foreach($user as $row)
				{
					$output .= '
					<tr>
						<td class="text-center">'.$i++.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->email.'</td>
						<td class="text-center">'
							.'<a href="#" data-id="'.$row->id.'" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal'.$row->id.'">Delete</a>'.
						'</td>
					</tr>
					';
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

	public function softDel(Request $request)
	{
		// update data user
		DB::table('users')->where('id',$request->id)->update([
			'recipient' => $request->recipient
		]);
		// alihkan halaman ke halaman user
		return redirect('email')->with('success',' Data berhasil dihapus!');
	}

	public function updateUser(Request $request)
	{
		// update data user
		DB::table('users')->where('id',$request->id)->update([
			'recipient' => $request->recipient
		]);
		// alihkan halaman ke halaman user
		return redirect('email')->with('success',' Data berhasil ditambahkan!');
	}

	public function selectSearch(Request $request)
	{
		$input = $request->all();

        if (!empty($input['query'])) {
            $data = User::select(["id", "name"])
                ->where("name", "LIKE", "%{$input['query']}%")
				// ->having('recipient', 0)
                ->get();
        } else {
            $data = User::select(["id", "name"])
				->where('recipient', 0)
				->orWhere('recipient', NULL)
				->limit(10)
                ->get();
        }

        $users = [];

        if (count($data) > 0) {
            foreach ($data as $user) {
                $users[] = array(
                    "id" => $user->id,
                    "text" => $user->name,
                );
            }
        }
        return response()->json($users);
    }

	public function sendmail($uuid){
		$data = User::select(["email"])
		->where('recipient', 1)
		->get();

		Mail::to($data)->send(new SendMail($uuid));
		// dd("Email is Sent.");
		// return "Email telah dikirim";
	}

	public function sendmail2($id){
		$data = User::select(["email"])
		->where('recipient', 1)
		->get();

		Mail::to($data)->send(new SendMail2($id));
		// dd("Email is Sent.");
		// return "Email telah dikirim";
	}
}
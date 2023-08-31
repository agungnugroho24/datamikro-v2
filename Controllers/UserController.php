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

class UserController extends Controller
{

	public function user(){
		$user = User::leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
			->leftjoin('role_user as ru', 'ru.user_id', 'users.id')
			->leftjoin('roles', 'roles.id', 'ru.role_id')
			->select('users.*', 'unitkerjas.name as uke_name', 'roles.display_name as role')
			->where('status', '1')
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
			$output="";

			$user = User::leftjoin('unitkerjas', 'unitkerjas.iduke', 'users.iduke')
					->leftjoin('role_user as ru', 'ru.user_id', 'users.id')
					->leftjoin('roles', 'roles.id', 'ru.role_id')
					->select('users.*', 'unitkerjas.name as uke_name', 'roles.display_name as role')
					->where('status', '1')
					->where(function($query) use ($request) {
                        $query
						->where('users.name', 'like', '%'.$request->search.'%')
						->orWhere('users.email', 'like', '%'.$request->search.'%');
                    })
					->orderBy('users.id', 'ASC')
					->paginate(10);
        
        	if($user->isNotEmpty())
            {
                $i = 1;
                foreach ($user as $key => $user)
                {
                $output.='<tr>'.
                '<td>'.$i++.'</td>'.
                '<td>'.$user->name.'</td>'.
                '<td>'.$user->uke_name.'</td>'.
				'<td>'.$user->email.'</td>'.
				'<td>'.$user->username.'</td>'.
				'<td>'.$user->role.'</td>'.
				'<td>'.$user->last_login_at.'</td>'.
                '<td>'.
                    '<div class="bd-example text-center">
                        <a class="" href="'.route('user.edit', $user->username).'"><button type="button" class="btn btn-sm btn-primary"> Edit</button></a>
                        <a href="#" data-id="'.$user->id.'" class="btn btn-sm btn-danger mt-1" data-toggle="modal" data-target="#deleteModal'.$user->id.'">Delete</a>
                    </div>'
                .'</td>'.
                '</tr>';
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

	public function delete($id)
    {
        $data = array(
            'status' => 0
        );
        User::where('id', $id)->update($data);
        return redirect()->route('user')->with('success','Data berhasil dihapus');
    }

	public function destroy(Request $request)
    {
        $data = array(
            'status' => 0
        );
        User::where('id', $id)->update($data);
        return 0;
    }
}
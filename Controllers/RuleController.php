<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.rule.rule',[
            'role' => Role::leftjoin(DB::raw('permission_role pr'), 'pr.role_id', '=', 'roles.id')
                        ->select(DB::raw('roles.*, count(pr.permission_id) total'))
                        ->groupBy('roles.id')
                        ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.rule.add',[
            'role' => Role::all(),
            'permission' => Permission::with('child')
                            ->where('parent', '=', '0')
                            ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->menu as $menu) {
            $data = array(
                'permission_id' => $menu,
                'role_id' => $request->role
            );
            DB::table('permission_role')->insert($data);
        }

        return redirect()->route('rule')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('pages.rule.edit',[
            'role' => $role,
            'permission' => Permission::with('child')
                            ->where('parent', '=', '0')
                            ->get(),
            'data' => DB::table('permission_role')
                        ->select(DB::raw('group_concat(permission_id) as isi'))
                        ->where('role_id', '=', $role->id)
                        ->groupBy('role_id')
                        ->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        DB::table('permission_role')->where('role_id', '=', $role->id)->delete();
        foreach ($request->menu as $menu) {
            $data = array(
                'permission_id' => $menu,
                'role_id' => $role->id
            );
            DB::table('permission_role')->insert($data);
        }

        return redirect()->route('rule')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return 0;
    }
}

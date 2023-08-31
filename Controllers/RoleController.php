<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.role.role',[
            'role' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.role.add', [
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
        $request->validate([
            "display_name" => "required"
        ]);

        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = Str::slug($request->display_name);
        $role->description = $request->description;
        $role->save();

        foreach ($request->menu as $menu) {
            $data = array(
                'permission_id' => $menu,
                'role_id' => $role->id
            );
            DB::table('permission_role')->insert($data);
        }

        return redirect()->route('role')->with('success', 'Berhasil menambahkan data');
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
        return view('pages.role.edit',[
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
        $validate = $request->validate([
            "display_name" => "required"
        ]);

        // $validate['name'] = Str::slug($request->display_name);
        $validate['description'] = $request->description;

        Role::where('id', $role->id)->update($validate);

        DB::table('permission_role')->where('role_id', '=', $role->id)->delete();
        if (isset($request->menu)) {
            foreach ($request->menu as $menu) {
                $data = array(
                    'permission_id' => $menu,
                    'role_id' => $role->id
                );
                DB::table('permission_role')->insert($data);
            }
        }
        
        return redirect()->route('role')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('roles')->where('name', '=', $request->name)->delete();
        return 0;
    }
}

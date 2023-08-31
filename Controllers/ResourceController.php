<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.resource.resource',[
            'resource' => Permission::leftjoin(DB::raw('permissions pr'), 'pr.id', '=', 'permissions.parent')
                        ->select(DB::raw('permissions.*, pr.display_name as parent_name'))
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
        return view ('pages.resource.add',[
            'parent' => Permission::all()
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
            "code" => "required|unique:permissions,name",
            "name" => "required"
        ]);

        $permission = new Permission();
        $permission->name = $request->code;
        $permission->display_name = $request->name;
        $permission->description = $request->description;
        $permission->parent = $request->parent;
        $permission->save();

        return redirect()->route('resource')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('pages.resource.edit',[
            'resource' => $permission,
            'parent' => Permission::where('permissions.id', '!=' , $permission->id)
                        ->where('permissions.parent', '!=', $permission->id)
                        ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            "code" => "required",
            "name" => "required"
        ]);

        $validate['name'] = $request->code;
        $validate['display_name'] = $request->name;
        $validate['description'] = $request->description;
        $validate['parent'] = $request->parent;

        Permission::where('id', $permission->id)->update($validate);
        return redirect()->route('resource')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('permissions')->where('name', '=', $request->name)->delete();
        return 0;
    }

    public function search(Request $request)
    {
        if(!empty($request)){
        $query = $request->all();
        $resource = DB::table('permissions')->orderBy('id', 'ASC');
            if(isset($request->name) AND $request->name != '' AND $request->name != 'all')
        $resource = $resource->where('name', 'like', "%" .$request->name. "%");
        $resource = $resource->paginate(10);
        return view('pages.resource.resource', compact('resource','query'));
        }

        $resource = DB::table('permissions')
            ->orderBy('id', 'ASC')
            ->paginate(10);
        return view('pages.resource.resource', compact('permissions'));
        
    }

    // public function search(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //     $output="";

    //     $resource = DB::table('permissions')
    //      ->where('name', 'like', '%'.$request->search.'%')
    //      ->orWhere('display_name', 'like', '%'.$request->search.'%')
    //      ->get();
        
    //     if($resource)
    //         {
    //             $i = 1;
    //             foreach ($resource as $key => $resource)
    //             {
    //             $output.='<tr>'.
    //             '<td>'.$i++.'</td>'.
    //             '<td>'.$resource->name.'</td>'.
    //             '<td>'.$resource->display_name.'</td>'.
    //             '<td>'.$resource->description.'</td>'.
    //             '<td>'.$resource->parent.'</td>'.
    //             '<td>'.
    //                 '<div class="bd-example text-center">
    //                     <a class="" href="'.route('resource.edit', $resource->name).'"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</button></a>
    //                     <a href="#" data-id="'.$resource->id.'" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal'.$resource->id.'">Delete</a>
    //                 </div>'
    //             .'</td>'.
    //             '</tr>';
    //             }
    //         return Response($output);
    //         }
    //     }
    // }

    public function delete($id)
    {
        Permission::where('id', $id)->delete();
        return redirect()->route('resource')->with('success','Data berhasil dihapus');
    }
}

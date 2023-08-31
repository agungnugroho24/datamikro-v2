<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Source;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $source = DB::table('sources')->Paginate(10);
        //         return view('pages.sumber.sumber', ['sources' => $source]);

        return view('pages.sumber.sumber',[
            'source' => Source::whereNull('deleted_at')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.sumber.add_sumber');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// dd($request);
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:sources,slug"
        ]);

        $source = new Source();
        $source->name = $request->name;
        $source->slug = $request->slug;
        $source->alias = $request->alias;
        $source->description = $request->description;
        $source->created_by = auth()->user()->id;
        $source->save();

        return redirect()->route('source')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        return view('pages.sumber.edit',[
            'source' => $source
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        $validate = $request->validate([
            "name" => "required",
            "slug" => "required"
        ]);

        $validate['alias'] = $request->alias;
        $validate['description'] = $request->description;
        $validate['updated_by'] = auth()->user()->id;

        Source::where('id', $source->id)->update($validate);
        return redirect()->route('source')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = array(
            'deleted_by' => auth()->user()->id,
            'deleted_at' => date("Y-m-d H:i:s")
        );
        Source::where('slug', $request->slug)->update($data);
        return redirect()->route('source')->with('success','Data berhasil dihapus');
    }

    public function checkSlug(Request $request)
    {
    	if ($request->name!='' && $request->name!=null) {
	        $slug = SlugService::createSlug(Source::class, 'slug', $request->name);
    	}else{
    		$slug = $request->name;
    	}
        return response()->json(['slug' => $slug]);
    }

    // public function search(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $output="";

    //         $source = DB::table('sources')
    //         ->where('name', 'like', '%'.$request->search.'%')
    //         ->orWhere('slug', 'like', '%'.$request->search.'%')
    //         ->get();
            
    //         if($source)
    //         {
    //             $i = 1;
    //             foreach ($source as $key => $source)
    //             {
    //             $output.='<tr>'.
    //             '<td>'.$i++.'</td>'.
    //             '<td>'.$source->name.'</td>'.
    //             '<td>'.$source->alias.'</td>'.
    //             '<td>'.$source->description.'</td>'.
    //             '<td>'.
    //                 '<div class="bd-example text-center">
    //                     <a class="" href="'.route('source.edit', $source->slug).'"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</button></a>
    //                     <a href="#" data-id="'.$source->slug.'" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal'.$source->slug.'">Delete</a>
    //                 </div>'
    //             .'</td>'.
    //             '</tr>';
    //             }
    //         return Response($output);
    //         }
    //     }
    // }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('sources')
                    ->where('name', 'like', '%'.$query.'%')
                    ->whereNull('deleted_at')
                    ->orWhere('alias', 'like', '%'.$query.'%')
                    ->orderBy('id', 'ASC')
                    ->paginate(10);
            }else{
                $data = DB::table('sources')
                ->whereNull('deleted_at')
                ->paginate(10);
            }
            
            $total_row = $data->count();
            $grand_total = $data->total();
            if($total_row > 0)
            {
                $i = 1;
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                        <td class="text-center">'.$i++.'</td>
                        <td>'.$row->name.'</td>
                        <td>'.$row->alias.'</td>
                        <td>'.$row->description.'</td>
                        <td>'
                            .'<div class="bd-example text-center">
                            <a class="" href="'.route('source.edit', $row->slug).'"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</button></a>
                            <a href="#" data-id="'.$row->slug.'" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal'.$row->slug.'">Delete</a>
                            </div>'.
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

    public function delete($slug)
    {
        Source::where('slug', $slug)->delete();
        return redirect()->route('source')->with('success','Data berhasil dihapus');
    }

}

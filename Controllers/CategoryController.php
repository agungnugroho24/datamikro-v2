<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Metadata;
use App\Models\CategoryFile;
use App\Models\Source;
use App\Models\Unitkerja;
use App\Models\Log;
use App\Models\Tag;
use App\Models\CategoryTag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.sumber.sumber',[
            'category' => Category::all()->whereNull('deleted_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.kategori.kategori');
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
            "slug" => "required|unique:categories,slug"
        ]);

        $uke = Unitkerja::where('iduke', auth()->user()->iduke)->first();

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->uke_id = $uke->id;
        $category->created_by = auth()->user()->id;
        $category->save();

        return redirect()->route('datadasar')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pages.kategori.edit',[
            'category' => $category,
            'tag' => CategoryTag::where('category_id', $category->id)
                        ->leftJoin('tags', 'tags.id', 'category_tags.tag_id')->get(),
            'source' => Source::whereNull('deleted_at')->get(),
            'metadata' => Metadata::where('category_id', $category->id)->first(),
            'files' => CategoryFile::where('category_id', $category->id)
                        ->select('*', DB::raw('
                            (CASE WHEN size < 1000000 
                            THEN CONCAT(CEILING(size / 1024.0), " KB")
                            ELSE 
                            CONCAT(FORMAT(size / 1048576.0, "N3"), " MB")
                            END) AS filesize'))
                        ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {     
        $validate = $request->validate([
            "name" => "required",
            "slug" => "required"
        ]);

        $validate['updated_by'] = auth()->user()->id;
        $validate['description'] = $request->description;

        $metadata = Metadata::updateOrCreate(['category_id' => $category->id] ,[
            'category_id' => $category->id,
            'source_id' => $request->source,
            'period' => $request->period,
            'frequency' => $request->frequency,
            'release_date' => $request->release_date,
            'update' => $request->update,
            'analysis' => $request->analysis,
            'granularity' => $request->granularity,
            'coverage' => $request->coverage,
            'link_name' => $request->link_name,
            'link' => $request->link,
            'individu' => $request->individu,
            'lokus' => $request->lokus,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'kabkot' => $request->kabkot,
            'provinsi' => $request->provinsi,
            'nasional' => $request->nasional,
            'jeniskeg' => $request->jeniskeg,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
   
        $tagid = array();
        $query = CategoryTag::where('category_id', $category->id);
        if ($request->tags!=null) {
            foreach ($request->tags as $tag) {
                $tagisi = Tag::updateOrCreate(['tag' => $tag],['tag' => $tag]);
                $categoryTag = CategoryTag::updateOrCreate(['category_id' => $category->id, 'tag_id' => $tagisi->id],[
                    'category_id' => $category->id, 
                    'tag_id' => $tagisi->id
                ]);
                array_push($tagid, $tagisi->id);
            }
            $query = $query->whereNotIn('tag_id',$tagid);
        }
        $query->delete();

        Category::where('id', $category->id)->update($validate);
        return redirect()->route('datadasar')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = array(
            'deleted_by' => auth()->user()->id,
            'deleted_at' => date("Y-m-d H:i:s")
        );
        Category::where('slug', $request->slug)->update($data);
        return 0;
    }

    public function checkSlug(Request $request)
    {
    	if ($request->name!='' && $request->name!=null) {
	        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
    	}else{
    		$slug = $request->name;
    	}
        return response()->json(['slug' => $slug]);
    }

    public function uploadFile(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'files.*' => 'required|mimes:xls,xlsx,doc,docx,ppt,pptx,pdf,zip',
        ]);

        $folder = 'public/files';

        $filename = '';
        if($request->hasfile('files'))
        {
            foreach($request->file('files') as $key => $file)
            {
                $name = $this->generateName($folder.'/'.$file->getClientOriginalName());
                $path = $file->storeAs($folder, basename($name));
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $categoryfile = new CategoryFile();
                $categoryfile->category_id = $request->id;
                $categoryfile->name = basename($name);
                $categoryfile->size = $size;
                $categoryfile->type = $extension;
                $categoryfile->path = $path;
                $categoryfile->created_by = auth()->user()->id;
                $categoryfile->save();                
                if ($key==0) {
                    $filename = basename($name);
                }else{
                    $filename .= ', '.basename($name);
                }
            }
        }

        $param = $request->all();
        unset($param['_token']);
        $log = new Log();
        $log->uri = $request->route()->uri;
        $log->type = 'upload';
        $log->data =  $filename;
        $log->param = json_encode($param);
        $log->uke_id = auth()->user()->iduke;
        $log->username = auth()->user()->username;
        $log->save();

        echo 1;

        // Store the file
        // Storage::disk('local')->put($fileName, File::get($file));
 
        // dd($request->files);
    }

    public function deletefile(Request $request)
    {
        $file = CategoryFile::find($request->id);
        $delete = $file->delete();
        if ($delete==1) {
            Storage::delete($file->path);
        }
        
        $param = $request->all();
        unset($param['_token']);
        $log = new Log();
        $log->uri = $request->route()->uri;
        $log->type = 'delete';
        $log->data =  $file->name;
        $log->param = json_encode($param);
        $log->uke_id = auth()->user()->iduke;
        $log->username = auth()->user()->username;
        $log->category_id = $file->category_id;
        $log->save();
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

    public function undercons(){
		return view('errors.cs');
	}
}
